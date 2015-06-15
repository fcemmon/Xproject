//
//  ServiceTableViewCell.h
//  X-Project
//
//  Created by Admin on 6/3/15.
//  Copyright (c) 2015 admin. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <SDWebImage/UIImageView+WebCache.h>

@interface ServiceTableViewCell : UITableViewCell

@property (weak, nonatomic) IBOutlet UIImageView *cellImageView;
@property (weak, nonatomic) IBOutlet UILabel *cellLabel;
@end
