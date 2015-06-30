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
#import "Constants.h"
#import "AppManager.h"
#define METERS_PER_MILE 1852

@interface ServiceViewController ()<TakePhotoDelegate,CLLocationManagerDelegate, UITextFieldDelegate>{
    CLLocationCoordinate2D currentCentre;
    float latitude,longitude;
}
@property (nonatomic, strong) TakePhoto *takePhoto;
@property (nonatomic, strong) UIImage *mImage;
@property (strong, nonatomic) CLLocationManager *locationManager;
@property (strong, nonatomic) NSString *user_id;
@property (strong, nonatomic) AppManager *appManager;

@end

@implementation ServiceViewController

@synthesize appManager;

- (void)viewDidLoad {
    [super viewDidLoad];
    // Do any additional setup after loading the view.
    
    appManager = [AppManager sharedManager];
    self.user_id = [appManager getUserID];
    
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
}

#pragma mark - upload Image 

- (void)uploadImage {
    
    AFHTTPRequestOperationManager *manager = [AFHTTPRequestOperationManager manager];

    NSData *imageData = UIImageJPEGRepresentation(self.imageView.image, 0.5);
    
    NSString * postImageURL = [NSString stringWithFormat:@"%@services/postimage?user_id=%@", mHostURL, self.user_id];
    [manager POST:postImageURL parameters:nil constructingBodyWithBlock:^(id<AFMultipartFormData> formData){
        [formData appendPartWithFileData:imageData name:@"photo" fileName:@"image.jpg" mimeType:@"image/jpeg"];
    } success:^(AFHTTPRequestOperation *operation, id responseObject) {
        NSLog(@"Success: %@", responseObject);
        NSDictionary *jsonResult = responseObject;
        if ([[jsonResult objectForKey:@"status"] isEqualToString:@"success"]) {
            NSString * fileURL = [jsonResult objectForKey:@"photo_url"];
            [self createService:fileURL];
        }else{
            [[[UIAlertView alloc] initWithTitle:@"Server Error" message:@"Server error occured" delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil] show];
        }
    } failure:^(AFHTTPRequestOperation *operation, NSError *error) {
        
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
        NSLog(@"Success: %@", responseObject);
        NSDictionary *jsonResult = responseObject;
        if ([[jsonResult objectForKey:@"status"] isEqualToString:@"success"]) {
            [[[UIAlertView alloc] initWithTitle:@"Offer Service" message:@"Service created." delegate:nil cancelButtonTitle:@"OK" otherButtonTitles: nil] show];
        }else{
            [[[UIAlertView alloc] initWithTitle:@"Server Error" message:@"Server error occured" delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil] show];
        }
    } failure:^(AFHTTPRequestOperation *operation, NSError *error) {
        NSLog(@"Error: %@", error);
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

@end
