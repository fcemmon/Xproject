//
//  Left_MenuView.h
//  X-Project
//
//  Created by admin on 5/27/15.
//  Copyright (c) 2015 admin. All rights reserved.
//

#ifndef X_Project_Left_MenuView_h
#define X_Project_Left_MenuView_h


#endif

#import <UIKit/UIKit.h>
#import "SlideNavigationController.h"

@interface LeftMenuViewController : UIViewController <UITableViewDelegate, UITableViewDataSource>

@property (nonatomic, strong) IBOutlet UITableView *tableView;
@property (nonatomic, assign) BOOL slideOutAnimationEnabled;

@end
