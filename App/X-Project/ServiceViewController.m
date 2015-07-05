//
//  ServiceView.m
//  X-Project
//
//  Created by Admin on 6/2/15.
//  Copyright (c) 2015 admin. All rights reserved.
//

#import "ServiceViewController.h"
#import "TakePhoto.h"
#import <CoreLocation/CoreLocation.h>
#import <AFNetworking.h>
#import <UIViewController+ECSlidingViewController.h>
#import "METransitions.h"
#import "MEDynamicTransition.h"
#import "Constants.h"
#import "AppManager.h"
#define METERS_PER_MILE 1852

@interface ServiceViewController ()<TakePhotoDelegate,CLLocationManagerDelegate, UITextFieldDelegate>{
    CLLocationCoordinate2D currentCentre;
    float latitude,longitude;
    NSString * username, * phoneNumber, * email;
}
@property (nonatomic, strong) TakePhoto *takePhoto;
@property (nonatomic, strong) UIImage *mImage;
@property (strong, nonatomic) CLLocationManager *locationManager;
@property (strong, nonatomic) NSString *user_id;
@property (strong, nonatomic) AppManager *appManager;
@property (nonatomic, strong) METransitions *transitions;
@property (nonatomic, strong) UIPanGestureRecognizer *dynamicTransitionPanGesture;
@property (weak, nonatomic) IBOutlet UIActivityIndicatorView *activityIndicator;

@end

@implementation ServiceViewController

@synthesize appManager;

- (void)viewDidLoad {
    [super viewDidLoad];
    // Do any additional setup after loading the view.
    
    appManager = [AppManager sharedManager];
    self.user_id = [appManager getUserID];
    
    username = [[NSUserDefaults standardUserDefaults] objectForKey:@"userName"];
    if (!username) {
        username = @"";
    }
    
    phoneNumber = [[NSUserDefaults standardUserDefaults] objectForKey:@"phoneNumber"];
    if (!phoneNumber) {
        phoneNumber = @"";
    }
    
    email = [[NSUserDefaults standardUserDefaults] objectForKey:@"email"];
    if (!email) {
        email = @"";
    }
    
    self.username.text = username;
    self.phone_number.text = phoneNumber;
    self.email.text = email;
    self.address.text = [appManager getAddress];
    
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
    [self reloadMapView];
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

#pragma mark - Button Actions

- (IBAction)onUpdatePicture:(id)sender {
    if (self.takePhoto == nil ) {
        self.takePhoto = [[TakePhoto alloc] init:self];
        self.takePhoto.actiondelegate = self;
        [self addChildViewController:self.takePhoto];
    }
    [self.takePhoto takePhoto];
}

#pragma mark - TakePhotoDelegate

- (void)setImage:(UIImage *)aImage {
    self.mImage = aImage;
    self.imageView.image = aImage;
    [self.takePhoto removeFromParentViewController];
}

#pragma mark - upload Image 

- (void)uploadImage {
    
    [self.activityIndicator startAnimating];
    
    AFHTTPRequestOperationManager *manager = [AFHTTPRequestOperationManager manager];

    NSData *imageData = UIImageJPEGRepresentation(self.imageView.image, 0.5);
    
    NSString * postImageURL = [NSString stringWithFormat:@"%@services/postimage?user_id=%@", mHostURL, self.user_id];
    [manager POST:postImageURL parameters:nil constructingBodyWithBlock:^(id<AFMultipartFormData> formData){
        [formData appendPartWithFileData:imageData name:@"photo" fileName:@"image.jpg" mimeType:@"image/jpeg"];
    } success:^(AFHTTPRequestOperation *operation, id responseObject) {
        NSLog(@"Success: %@", responseObject);
        NSDictionary *jsonResult = responseObject;
        [self.activityIndicator stopAnimating];
        if ([[jsonResult objectForKey:@"status"] isEqualToString:@"success"]) {
            NSString * fileURL = [jsonResult objectForKey:@"photo_url"];
            [self createService:fileURL];
        }else{
            [[[UIAlertView alloc] initWithTitle:@"Server Error" message:@"Server error occured" delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil] show];
        }
    } failure:^(AFHTTPRequestOperation *operation, NSError *error) {
        [self.activityIndicator stopAnimating];
    }];
}

#pragma mark - API Function

- (void)createService:(NSString * )imageURL {
    NSLog(@"Create Service");
    NSLog(@"%@",self.username.text);
    NSLog(@"%@",self.phone_number.text);
    NSLog(@"%@",self.email.text);
    NSLog(@"%@",self.address.text);
    NSLog(@"%@",self.service_name.text);
    NSLog(@"%@",self.user_id);
    NSLog(@"%@",[NSString stringWithFormat:@"%f", currentCentre.latitude]);
    NSLog(@"%@",[NSString stringWithFormat:@"%f", currentCentre.longitude]);
    
    NSString *string_url = [NSString stringWithFormat:@"%@%@",mHostURL,mOfferService];
    
    [self.activityIndicator startAnimating];
    
    AFHTTPRequestOperationManager *manager = [AFHTTPRequestOperationManager manager];
    NSDictionary *parameters = @{@"user_id": self.user_id,
                                 @"latitude":[NSString stringWithFormat:@"%f", currentCentre.latitude],
                                 @"longitude":[NSString stringWithFormat:@"%f", currentCentre.longitude],
                                 @"service_name":self.service_name.text,
                                 @"user_name":self.username.text,
                                 @"phonenumber":self.phone_number.text,
                                 @"phone_type":@"",
                                 @"email":self.email.text,
                                 @"email_type":@"",
                                 @"address":self.address.text,
                                 @"address_type":@"",
                                 @"photo":imageURL
                                 };
    
    [manager POST:string_url parameters:parameters success:^(AFHTTPRequestOperation *operation, id responseObject) {
        [self.activityIndicator stopAnimating];
        NSLog(@"Success: %@", responseObject);
        NSDictionary *jsonResult = responseObject;
        if ([[jsonResult objectForKey:@"status"] isEqualToString:@"success"]) {
            
            [[NSUserDefaults standardUserDefaults] setObject:self.username.text forKey:@"userName"];
            [[NSUserDefaults standardUserDefaults] setObject:self.phone_number.text forKey:@"phoneNumber"];
            [[NSUserDefaults standardUserDefaults] setObject:self.email.text forKey:@"email"];
            
            [[[UIAlertView alloc] initWithTitle:@"Offer Service" message:@"Service created." delegate:nil cancelButtonTitle:@"OK" otherButtonTitles: nil] show];
        }else{
            [[[UIAlertView alloc] initWithTitle:@"Server Error" message:@"Server error occured" delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil] show];
        }
    } failure:^(AFHTTPRequestOperation *operation, NSError *error) {
        NSLog(@"Error: %@", error);
        [self.activityIndicator stopAnimating];
    }];
}

#pragma mark -

#pragma mark TextView delegate

-(BOOL)textFieldShouldReturn:(UITextField*)textField
{
    NSInteger nextTag = textField.tag + 1;
    // Try to find next responder
    UIResponder* nextResponder = [textField.superview viewWithTag:nextTag];
    if (nextResponder) {
        // Found next responder, so set it.
        [nextResponder becomeFirstResponder];
    } else {
        // Not found, so remove keyboard.
        [textField resignFirstResponder];
    }
    return NO; // We do not want UITextField to insert line-breaks.
}

#pragma mark -

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

- (IBAction)menuTap:(id)sender {
    [self.slidingViewController anchorTopViewToRightAnimated:YES];
}

- (IBAction)offerButtonClicked:(id)sender {
    [self uploadImage];
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
             
             [self.address setText:strAdd];
             appManager.address = strAdd;
         }
     }];
}

@end
