//
//  HomeViewController.m
//  X-Project
//
//  Created by admin on 5/27/15.
//  Copyright (c) 2015 admin. All rights reserved.
//

#import "HomeViewController.h"
#import "METransitions.h"
#import "MEDynamicTransition.h"
#import "AppManager.h"
#import "UIViewController+ECSlidingViewController.h"
#import <CoreLocation/CoreLocation.h>
#import <UIKit/UIKit.h>
#import <AFNetworking.h>
#import "Constants.h"
#import "ServiceTableViewCell.h"
#define METERS_PER_MILE 1000


@interface HomeViewController ()<CLLocationManagerDelegate,UIAlertViewDelegate, UISearchBarDelegate>{
    CLLocationCoordinate2D currentCentre;
    float latitude,longitude;
    NSMutableArray *services;
    NSMutableArray *filtered_services;
}
@property (nonatomic, strong) METransitions *transitions;
@property (nonatomic, strong) UIPanGestureRecognizer *dynamicTransitionPanGesture;
@property (strong, nonatomic) CLLocationManager *locationManager;
@property (nonatomic, strong) AppManager *appManager;
@property (nonatomic, strong) CLLocation * currentLocation;
@property (nonatomic, strong) NSString *user_Token;
@property (nonatomic, strong) NSString *user_id;
@property (nonatomic, strong) NSString *selected_service_id;
@property (weak, nonatomic) IBOutlet UIActivityIndicatorView *activityIndifiner;

@end

@implementation HomeViewController

@synthesize appManager;

- (void)viewDidLoad
{
    [super viewDidLoad];
    self.mapView.delegate = self;
    self.mapView.showsUserLocation = YES;
    
    //get current location
    self.locationManager = [[CLLocationManager alloc]init];
    self.locationManager.delegate = self;
    self.locationManager.distanceFilter = kCLDistanceFilterNone;
    self.locationManager.desiredAccuracy = kCLLocationAccuracyBest;
    [self.locationManager startUpdatingLocation];
    [self.locationManager requestAlwaysAuthorization];
    latitude = self.locationManager.location.coordinate.latitude;
    longitude = self.locationManager.location.coordinate.longitude;
    
    appManager = [AppManager sharedManager];
    self.user_Token = [appManager getUserToken];
    if (self.user_Token == nil) {
        self.user_Token = [[[UIDevice currentDevice] identifierForVendor] UUIDString];
        [appManager setUserToken:self.user_Token];
    }else{
        NSLog(@"UDID: %@", self.user_Token);
    }
    
    UITapGestureRecognizer *tap = [[UITapGestureRecognizer alloc] initWithTarget:self action:@selector(dismissKeyboard)];
    [self.mapView addGestureRecognizer:tap];
}
- (void)viewWillAppear:(BOOL)animated {
    [super viewWillAppear:animated];
    
    [self setGesture];
    [self reloadMapView];
    [self getService:@""];
}

-(void)reloadMapView{
    // show map
    currentCentre.latitude = self.locationManager.location.coordinate.latitude;
    currentCentre.longitude = self.locationManager.location.coordinate.longitude;
    MKCoordinateRegion viewRegion = MKCoordinateRegionMakeWithDistance(currentCentre, 10*METERS_PER_MILE, 10*METERS_PER_MILE);
    [self.mapView setRegion:viewRegion animated:YES];
    //set pin
    MKPointAnnotation *secondpoint=[[MKPointAnnotation alloc]init];
    secondpoint.coordinate=currentCentre;
    secondpoint.title = @"My location";
//    [self.mapView addAnnotation:secondpoint];
}


- (void)viewWillDisappear:(BOOL)animated {
    [super viewWillDisappear:animated];
    [self removeGesture];
}

#pragma Web server APIs
- (void) getService:(NSString * )searchKey{
    
    self.label1.text = @"";
    self.label2.text = @"";
    [self.image setImage:[UIImage imageNamed:@"userprofile.png"]];
    
    NSString *string_url = [NSString stringWithFormat:@"%@%@",mHostURL,mGetService];
    [self.activityIndifiner startAnimating];
    AFHTTPRequestOperationManager *manager = [AFHTTPRequestOperationManager manager];
    NSDictionary *parameters = @{@"auth_token": self.user_Token,
                                 @"latitude":[NSString stringWithFormat:@"%f", currentCentre.latitude],
                                 @"longitude":[NSString stringWithFormat:@"%f", currentCentre.longitude],
                                 @"service_name":searchKey};
    [manager POST:string_url parameters:parameters success:^(AFHTTPRequestOperation *operation, id responseObject) {
        
        [self.activityIndifiner stopAnimating];
        services = [[NSMutableArray alloc] init];
        filtered_services = [[NSMutableArray alloc] init];
        NSLog(@"JSON: %@", responseObject);
        NSDictionary *jsonResult = responseObject;
        if ([[jsonResult objectForKey:@"status"] isEqualToString:@"success"]) {
            
            self.user_id = [jsonResult objectForKey:@"user_id"];
            [[NSUserDefaults standardUserDefaults] setValue:self.user_id forKey:@"appId"];
            [appManager setUserID:self.user_id];
            NSArray *json_services = [jsonResult objectForKey:@"services"];
            for (int i = 0; i < [json_services count]; i++) {
                NSDictionary *temp_service = json_services[i];
                [services addObject:temp_service];
            }
            filtered_services = [[NSMutableArray alloc] initWithArray:services];
            [self setMapPin];
            [self.tblview reloadData];
        }else{
            [[[UIAlertView alloc] initWithTitle:@"Server Error" message:@"Server error occured" delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil] show];
        }
    } failure:^(AFHTTPRequestOperation *operation, NSError *error) {
        NSLog(@"Error: %@", error);
    }];
}

- (void) search:(NSString*)searchText {
    
}
- (BOOL) searchBarShouldBeginEditing:(UISearchBar *)searchBar {
    return YES;
}

- (void) searchBar:(UISearchBar *)searchBar textDidChange:(NSString *)searchText {
    [self search:searchText];
}
-(void)searchBarSearchButtonClicked:(UISearchBar *)searchBar{
    if ( searchBar.text.length >= 1 ) {
        [self getService_by_name:searchBar.text];
        NSLog(@"%@",searchBar.text);
    }
    if (searchBar.text.length == 0) {
        filtered_services = [[NSMutableArray alloc] initWithArray:services];
        [self setMapPin];
        [self.tblview reloadData];
    }
    
    [searchBar resignFirstResponder];
}

- (void) getService_by_name:(NSString *)searchkey{
    [self getService:searchkey];
}

- (void) setMapPin{
    //set pin
    
    for (int i = 0; i < [filtered_services count]; i++) {
        MKPointAnnotation *secondpoint=[[MKPointAnnotation alloc] init];
        CLLocationCoordinate2D pin_location;
        pin_location.latitude = [[filtered_services[i] objectForKey:@"latitude"] floatValue];
        pin_location.longitude = [[filtered_services[i] objectForKey:@"longitude"] floatValue];
        
        secondpoint.coordinate = pin_location;
        secondpoint.title = [filtered_services[i] objectForKey:@"service_name"];
        [self.mapView addAnnotation:secondpoint];
    }
}

#pragma  mark UITabelView DB source

-(NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section{
    return [filtered_services count];
}

-(CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath{
    return 40;
}

-(ServiceTableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath{
    static NSString *tableIdentifier = @"found_serviceCell";
    ServiceTableViewCell *serviceCell = (ServiceTableViewCell*)[tableView dequeueReusableCellWithIdentifier:tableIdentifier];
    
    NSLog(@"%@",[filtered_services[indexPath.row] objectForKey:@"service_image"]);
    if ([filtered_services count] > indexPath.row) {
        serviceCell.cellLabel.text = [filtered_services[indexPath.row] objectForKey:@"service_name"];
        self.selected_service_id = [filtered_services[indexPath.row] objectForKey:@"service_id"];
        [serviceCell.cellImageView sd_setImageWithURL:[NSURL URLWithString:[filtered_services[indexPath.row] objectForKey:@"service_image"]]];
    }
    else    {
        serviceCell.cellLabel.text = @"";
        [serviceCell.cellImageView setImage:[UIImage imageNamed:@""]];
    }
    
    return serviceCell;
}

-(void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath{
    [self.image sd_setImageWithURL:[NSURL URLWithString:[filtered_services[indexPath.row] objectForKey:@"service_image"]]];
    NSString * serviceTitle = [filtered_services[indexPath.row] objectForKey:@"service_name"];
    NSString * serviceContext = [NSString stringWithFormat:@"This service is offered by %@", [filtered_services[indexPath.row] objectForKey:@"creater_name"]];
    self.label1.text = [NSString stringWithFormat:@"%@.  %@", [filtered_services[indexPath.row] objectForKey:@"service_id" ], serviceTitle];
    self.label2.text = serviceContext;
}

#pragma mark - Gesture

- (void) setGesture {
    self.transitions.dynamicTransition.slidingViewController = self.slidingViewController;
    
    NSDictionary *transitionData = self.transitions.all[0];
    id<ECSlidingViewControllerDelegate> transition = transitionData[@"transition"];
    if (transition == (id)[NSNull null]) {
        self.slidingViewController.delegate = nil;
    } else {
        self.slidingViewController.delegate = transition;
    }
    
    NSString *transitionName = transitionData[@"name"];
    if ([transitionName isEqualToString:METransitionNameDynamic]) {
        self.slidingViewController.topViewAnchoredGesture = ECSlidingViewControllerAnchoredGestureTapping | ECSlidingViewControllerAnchoredGestureCustom;
        self.slidingViewController.customAnchoredGestures = @[self.dynamicTransitionPanGesture];
        [self.navigationController.view removeGestureRecognizer:self.slidingViewController.panGesture];
        [self.navigationController.view addGestureRecognizer:self.dynamicTransitionPanGesture];
    } else {
        self.slidingViewController.topViewAnchoredGesture = ECSlidingViewControllerAnchoredGestureTapping | ECSlidingViewControllerAnchoredGesturePanning;
        self.slidingViewController.customAnchoredGestures = @[];
        [self.navigationController.view removeGestureRecognizer:self.dynamicTransitionPanGesture];
        [self.navigationController.view addGestureRecognizer:self.slidingViewController.panGesture];
    }
    
}

- (void) removeGesture {
    [self.navigationController.view removeGestureRecognizer:self.dynamicTransitionPanGesture];
    [self.navigationController.view removeGestureRecognizer:self.slidingViewController.panGesture];
}

- (UIPanGestureRecognizer *)dynamicTransitionPanGesture {
    if (_dynamicTransitionPanGesture) return _dynamicTransitionPanGesture;
    
    _dynamicTransitionPanGesture = [[UIPanGestureRecognizer alloc] initWithTarget:self.transitions.dynamicTransition action:@selector(handleGesture:)];
    
    return _dynamicTransitionPanGesture;
}

- (void) handleGesture:(UIPanGestureRecognizer *)recognizer {
   [self.transitions.dynamicTransition handlePanGesture:recognizer];
}

- (void) dismissKeyboard{
    [self.searchBar resignFirstResponder];
}

#pragma mark - IBActions

- (IBAction)menuButtonTapped:(id)sender {
    [self.slidingViewController anchorTopViewToRightAnimated:YES];
}

- (IBAction)likeButtonTapped:(id)sender{
    NSString *string_url = [NSString stringWithFormat:@"%@%@",mHostURL,mLikeService];
    
    AFHTTPRequestOperationManager *manager = [AFHTTPRequestOperationManager manager];
    NSDictionary *parameters = @{@"user_id": self.user_id,
                                 @"service_id":self.selected_service_id,
                                 @"like":@"1"};
    [manager POST:string_url parameters:parameters success:^(AFHTTPRequestOperation *operation, id responseObject) {
        NSLog(@"JSON: %@", responseObject);
        NSDictionary *jsonResult = responseObject;
        if ([[jsonResult objectForKey:@"status"] isEqualToString:@"success"]) {
            [[[UIAlertView alloc] initWithTitle:@"Like Service" message:@"You like this service." delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil] show];
        }else{
            [[[UIAlertView alloc] initWithTitle:@"Server Error" message:@"Server error occured" delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil] show];
        }
    } failure:^(AFHTTPRequestOperation *operation, NSError *error) {
        NSLog(@"Error: %@", error);
    }];
}

- (IBAction)commentButtonTapped:(id)sender{
    
    UIAlertView *commentAlert = [[UIAlertView alloc] initWithTitle:@"Comment" message:@"Please leave comment." delegate:self cancelButtonTitle:@"OK" otherButtonTitles: nil];
    commentAlert.alertViewStyle = UIAlertViewStylePlainTextInput;
    UITextField *commentText = [commentAlert textFieldAtIndex:0];
    commentText.keyboardType = UIKeyboardTypeDefault;
    commentText.placeholder = @"Enter your comment";
    [commentAlert show];}

- (void)alertView:(UIAlertView*)alertView clickedButtonAtIndex:(NSInteger)buttonIndex{
    NSLog(@"Alert button clicked");
    NSString *comment = [[alertView textFieldAtIndex:0] text];
    
    NSString *string_url = [NSString stringWithFormat:@"%@%@",mHostURL,mComment];
    
    AFHTTPRequestOperationManager *manager = [AFHTTPRequestOperationManager manager];
    NSDictionary *parameters = @{@"user_id": self.user_id,
                                 @"service_id":self.selected_service_id,
                                 @"comment":comment};
    [manager POST:string_url parameters:parameters success:^(AFHTTPRequestOperation *operation, id responseObject) {
        NSLog(@"JSON: %@", responseObject);
        NSDictionary *jsonResult = responseObject;
        if ([[jsonResult objectForKey:@"status"] isEqualToString:@"success"]) {
            [[[UIAlertView alloc] initWithTitle:@"Comment" message:@"You commented this service." delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil] show];
        }else{
            [[[UIAlertView alloc] initWithTitle:@"Server Error" message:@"Server error occured" delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil] show];
        }
    } failure:^(AFHTTPRequestOperation *operation, NSError *error) {
        NSLog(@"Error: %@", error);
    }];
}

- (void)locationManager:(CLLocationManager *)manager didUpdateToLocation:(CLLocation *)newLocation fromLocation:(CLLocation *)oldLocation
{
    CLGeocoder *geocoder = [[CLGeocoder alloc] init];
    
    CLLocation *currentLocation = newLocation;
    
    if (currentLocation != nil)
        NSLog(@"longitude = %.8f\nlatitude = %.8f", currentLocation.coordinate.longitude,currentLocation.coordinate.latitude);
    
    // stop updating location in order to save battery power
    [manager stopUpdatingLocation];
    
    
    [geocoder reverseGeocodeLocation:currentLocation completionHandler:^(NSArray *placemarks, NSError *error)
     {
         NSLog(@"Found placemarks: %@, error: %@", placemarks, error);
         if (error == nil && [placemarks count] > 0)
         {
             CLPlacemark *placemark = [placemarks lastObject];
             
             // strAdd -> take bydefault value nil
             NSString *strAdd = nil;
             
             if ([placemark.subThoroughfare length] != 0)
                 strAdd = placemark.subThoroughfare;
             
             if ([placemark.thoroughfare length] != 0)
             {
                 // strAdd -> store value of current location
                 if ([strAdd length] != 0)
                     strAdd = [NSString stringWithFormat:@"%@, %@",strAdd,[placemark thoroughfare]];
                 else
                 {
                     // strAdd -> store only this value,which is not null
                     strAdd = placemark.thoroughfare;
                 }
             }
             
             if ([placemark.postalCode length] != 0)
             {
                 if ([strAdd length] != 0)
                     strAdd = [NSString stringWithFormat:@"%@, %@",strAdd,[placemark postalCode]];
                 else
                     strAdd = placemark.postalCode;
             }
             
             if ([placemark.locality length] != 0)
             {
                 if ([strAdd length] != 0)
                     strAdd = [NSString stringWithFormat:@"%@, %@",strAdd,[placemark locality]];
                 else
                     strAdd = placemark.locality;
             }
             
             if ([placemark.administrativeArea length] != 0)
             {
                 if ([strAdd length] != 0)
                     strAdd = [NSString stringWithFormat:@"%@, %@",strAdd,[placemark administrativeArea]];
                 else
                     strAdd = placemark.administrativeArea;
             }
             
             if ([placemark.country length] != 0)
             {
                 if ([strAdd length] != 0)
                     strAdd = [NSString stringWithFormat:@"%@, %@",strAdd,[placemark country]];
                 else
                     strAdd = placemark.country;
             }
             
             appManager.address = strAdd;
         }
     }];
}

@end