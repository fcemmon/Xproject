//
//  MenuViewController.m
//  X-Project
//
//  Created by Admin on 5/30/15.
//  Copyright (c) 2015 admin. All rights reserved.
//

#import "MenuViewController.h"
#import "UIViewController+ECSlidingViewController.h"
#import "HomeViewController.h"
#import "MenuItem.h"

@interface MenuViewController ()

@property (nonatomic, strong) NSArray *menuItems;
@property (nonatomic, strong) UINavigationController *transitionsNavigationController;
@end

@implementation MenuViewController

@synthesize menuItems;

- (void)viewDidLoad {
    [super viewDidLoad];
    
    self.transitionsNavigationController = (UINavigationController*)self.slidingViewController.topViewController;
//    [self initializeMenuItems];
    menuItems = [[NSArray alloc] initWithObjects:@"Home", @"New Service", @"Contacts", @"Looking", nil];
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (void)viewWillDisappear:(BOOL)animated {
    [super viewWillDisappear:animated];
    [self.view endEditing:YES];
}

#pragma mark - UITableViewDataSource

- (CGFloat)tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath {
    return 50;
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section {
    return [menuItems count];
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath {
    static NSString *MyIdentifier = @"MyReuseIdentifier";
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:MyIdentifier];
    if (cell == nil) {
        cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault  reuseIdentifier:MyIdentifier];
    }
    cell.backgroundColor = [UIColor clearColor];
    cell.textLabel.text = menuItems[indexPath.row];
    return cell;
}

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath {    
    NSString *menuItem = self.menuItems[indexPath.row];
    
    self.slidingViewController.topViewController.view.layer.transform = CATransform3DMakeScale(1, 1, 1);
    
    if ([menuItem isEqualToString:@"Home"]) {
        self.slidingViewController.topViewController = self.transitionsNavigationController;
    } else if ([menuItem isEqualToString:@"New Service"]) {
        self.slidingViewController.topViewController = [self.storyboard instantiateViewControllerWithIdentifier:@"newServiceNavigationController"];
    } else if ([menuItem isEqualToString:@"Contacts"]){
        self.slidingViewController.topViewController = [self.storyboard instantiateViewControllerWithIdentifier:@"contactsNavigationController"];
    } else {
        self.slidingViewController.topViewController = [self.storyboard instantiateViewControllerWithIdentifier:@"lookingNavigationController"];
    }    
    
    [self.slidingViewController resetTopViewAnimated:YES];

}

@end


