//
//  NewServiceViewController.m
//  X-Project
//
//  Created by Admin on 5/30/15.
//  Copyright (c) 2015 admin. All rights reserved.
//

#import "NewServiceViewController.h"
#import "METransitions.h"
//#import "TakePhoto.h"
#import "MEDynamicTransition.h"
#import <UIViewController+ECSlidingViewController.h>
#import "ServiceViewController.h"

@interface NewServiceViewController ()
@property (nonatomic, strong) METransitions *transitions;
@property (nonatomic, strong) UIPanGestureRecognizer *dynamicTransitionPanGesture;

//@property (nonatomic, strong) TakePhoto *takePhoto;
//@property (nonatomic, strong) UIImage *mImage;
@property (nonatomic, strong) ServiceViewController *serviceViewController;
@end

@implementation NewServiceViewController

- (void)viewDidLoad {
    [super viewDidLoad];
    
    self.serviceViewController = [self.storyboard instantiateViewControllerWithIdentifier:@"ServiceViewController"];
    self.serviceViewController.view.frame = CGRectMake(0, 0, [UIScreen mainScreen].bounds.size.width, 640);
    
    [self.scrollview addSubview:self.serviceViewController.view];
    self.scrollview.contentSize = CGSizeMake(0, 640);
}

- (void)viewDidAppear:(BOOL)animated {
    [super viewDidAppear:animated];
    [self setGesture];
}

- (void)viewWillDisappear:(BOOL)animated {
    [super viewWillDisappear:animated];
    [self removeGesture];
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

- (IBAction)offerButtonTapped:(id)sender{
    [self.serviceViewController createService];
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
