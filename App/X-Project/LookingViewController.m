//
//  LookingViewController.m
//  X-Project
//
//  Created by Admin on 5/30/15.
//  Copyright (c) 2015 admin. All rights reserved.
//

#import "LookingViewController.h"
#import "METransitions.h"
#import "MEDynamicTransition.h"
#import <SDWebImage/UIImageView+WebCache.h>
#import <UIViewController+ECSlidingViewController.h>
#import <AFNetworking.h>
#import "ViewerImageCellTableViewCell.h"
#import "AppManager.h"
#import "Constants.h"

@interface LookingViewController ()
@property (nonatomic, strong) METransitions *transitions;
@property (nonatomic, strong) UIPanGestureRecognizer *dynamicTransitionPanGesture;
@property (nonatomic, strong) NSString *user_id;
@property (nonatomic, strong) AppManager *appManager;
@property (nonatomic, strong) NSMutableArray *viewers;

@end

@implementation LookingViewController

- (void)viewDidLoad {
    [super viewDidLoad];
    // Do any additional setup after loading the view.
    self.appManager = [AppManager sharedManager];
    self.user_id = [self.appManager getUserID];
    self.viewers = [[NSMutableArray alloc] init];
    [self getViewers];
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (void)viewWillAppear:(BOOL)animated {
    [super viewWillAppear:animated];
    [self setGesture];
}

- (void)viewWillDisappear:(BOOL)animated {
    [super viewWillDisappear:animated];
    [self removeGesture];
}

#pragma mark API call

- (void) getViewers{
    NSString *string_url = [NSString stringWithFormat:@"%@%@", mHostURL,mGetViewers];
    AFHTTPRequestOperationManager *manager = [AFHTTPRequestOperationManager manager];
    NSDictionary *parameters = @{@"user_id": self.user_id};
    [manager POST:string_url parameters:parameters success:^(AFHTTPRequestOperation *operation, id responseObject) {
        NSLog(@"JSON: %@", responseObject);
        
        self.viewers = [[NSMutableArray alloc] init];
        
        NSDictionary *jsonResult = responseObject;
        if ([[jsonResult objectForKey:@"status"] isEqualToString:@"success"]) {
            
            NSArray *json_Viewer = [jsonResult objectForKey:@"viewers"];
            for (int i = 0; i < [json_Viewer count]; i++) {
                NSDictionary *temp_Viewer = json_Viewer[i];
                [self.viewers addObject:temp_Viewer];
            }
            [self.ViewerImages reloadData];
        }else{
            [[[UIAlertView alloc] initWithTitle:@"Failed" message:@"You don't have any viewer now" delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil] show];
        }
    } failure:^(AFHTTPRequestOperation *operation, NSError *error) {
        NSLog(@"Error: %@", error);
    }];
}

#pragma mark TableView deleate 

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView   {
    return 1;
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section    {
   return [self.viewers count];
}

- (UITableViewCell*)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath   {
    static NSString * identifier = @"ViewerCell";
    
    UITableViewCell * cell = [tableView dequeueReusableCellWithIdentifier:identifier];
    if (cell == nil) {
        cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:identifier];
    }
    
    UIImageView * viewerImage = (UIImageView*)[cell viewWithTag:100];
    if ([[self.viewers[indexPath.row] objectForKey:@"photo"] isEqualToString:@""]) {
        [viewerImage setImage:[UIImage imageNamed:@"default_image_01"]];
    }else   {
        [viewerImage sd_setImageWithURL:[NSURL URLWithString:[self.viewers[indexPath.row] objectForKey:@"photo"]]];
    }
    
    return cell;
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

- (IBAction)menuButtonTapped:(id)sender {
    [self.slidingViewController anchorTopViewToRightAnimated:YES];
}
/*
#pragma mark - Navigation

// In a storyboard-based application, you will often want to do a little preparation before navigation
- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender {
    // Get the new view controller using [segue destinationViewController].
    // Pass the selected object to the new view controller.
}
*/

@end
