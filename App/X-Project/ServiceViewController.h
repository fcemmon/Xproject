//
//  ServiceView.h
//  X-Project
//
//  Created by Admin on 6/2/15.
//  Copyright (c) 2015 admin. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <MapKit/MapKit.h>
#import "CustomTextField.h"

@interface ServiceViewController : UIViewController<MKMapViewDelegate,CLLocationManagerDelegate>{
    
}
@property (weak, nonatomic) IBOutlet MKMapView *mapView;
@property (nonatomic, weak) IBOutlet UIImageView* imageView;
@property (nonatomic, weak) IBOutlet CustomTextField *username;
@property (nonatomic, weak) IBOutlet UIButton *btn_camera;
@property (nonatomic, weak) IBOutlet CustomTextField *phone_number;
@property (nonatomic, weak) IBOutlet CustomTextField *email;
@property (nonatomic, weak) IBOutlet CustomTextField *address;
@property (nonatomic, weak) IBOutlet CustomTextField *service_name;

- (void)createService;
- (void)uploadImage;
- (void)setImage:(UIImage *)aImage;

@end
