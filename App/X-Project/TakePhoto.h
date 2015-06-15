//
//  TakePhoto.h
//  X-Project
//
//  Created by Admin on 6/1/15.
//  Copyright (c) 2015 admin. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <UIKit/UIKit.h>

@class TakePhoto;

@protocol TakePhotoDelegate <NSObject>

@optional
- (void) setImage:(UIImage*)aImage;

@end

@interface TakePhoto : UIViewController<UIActionSheetDelegate, UIImagePickerControllerDelegate, UINavigationControllerDelegate>

@property (weak, nonatomic) id<TakePhotoDelegate> actiondelegate;

@property (nonatomic, strong) UIViewController *mParentViewController;
@property (nonatomic, assign) BOOL isAllowEditing;

- (id)init:(UIViewController*)viewController;
- (void) takePhoto;

@end