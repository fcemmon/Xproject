//
//  MapViewController.m
//  X-Project
//
//  Created by David Mulder on 7/1/15.
//  Copyright (c) 2015 admin. All rights reserved.
//

#import "MapViewController.h"
#import <MapKit/MapKit.h>
#import <CoreLocation/CoreLocation.h>
#import "AppManager.h"
#define METERS_PER_MILE 1000

@interface MapViewController()<MKMapViewDelegate>   {
    CLLocationCoordinate2D currentCentre;
    AppManager *appManager;
}
@property (weak, nonatomic) IBOutlet MKMapView *mapView;

@end

@implementation MapViewController

- (void)viewDidLoad {
    [super viewDidLoad];
    self.mapView.delegate = self;
    self.mapView.showsUserLocation = YES;
    appManager = [AppManager sharedManager];
    [self.navigationController.navigationBar setHidden:NO];
    // Do any additional setup after loading the view.
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

-(void)reloadMapView{
    // show map
    currentCentre.latitude = [appManager getCurrentLatitude];
    currentCentre.longitude = [appManager getCurrentLongitude];
    MKCoordinateRegion viewRegion = MKCoordinateRegionMakeWithDistance(currentCentre, 10*METERS_PER_MILE, 10*METERS_PER_MILE);
    [self.mapView setRegion:viewRegion animated:YES];
    //set pin
    MKPointAnnotation *secondpoint=[[MKPointAnnotation alloc]init];
    secondpoint.coordinate=currentCentre;
    secondpoint.title = @"CurrentService";
    //    [self.mapView addAnnotation:secondpoint];
}

@end
