//
//  HomeViewController.h
//  X-Project
//
//  Created by admin on 5/27/15.
//  Copyright (c) 2015 admin. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <CoreLocation/CoreLocation.h>
#import <MapKit/MapKit.h>

@interface HomeViewController : UIViewController <MKMapViewDelegate, CLLocationManagerDelegate,  UITableViewDataSource, UITableViewDelegate>{
    
}


@property (weak, nonatomic) IBOutlet UISearchBar *searchBar;
@property(nonatomic, retain) IBOutlet MKMapView *mapView;
@property(nonatomic, retain) IBOutlet UILabel *label1;
@property(nonatomic, retain) IBOutlet UILabel *label2;
@property(nonatomic, retain) IBOutlet UIImageView *image;
@property(nonatomic, retain) IBOutlet UIButton *btn_like;
@property(nonatomic, retain) IBOutlet UIButton *btn_comment;
@property(nonatomic, retain) IBOutlet UIButton *btn_skip;
@property(nonatomic, retain) IBOutlet UITableView *tblview;
//- (NSArray *)randomCoordinatesGenerator:(int)numberOfCoordinates;

@end