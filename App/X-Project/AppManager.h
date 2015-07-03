//
//  AppManager.h
//  X-Project
//
//  Created by Admin on 6/2/15.
//  Copyright (c) 2015 admin. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface AppManager : NSObject

@property (strong, nonatomic) NSString * address;

+ (instancetype) sharedManager;

- (void) setUserToken:(NSString*)token;
- (NSString*) getUserToken;
- (void) setUserID:(NSString*)_id;
- (NSString*) getUserID;
- (double)getCurrentLongitude;
- (void)setCurrentLongitude:(double)longitude;
- (double)getCurrentLatitude;
- (void)setCurrentLatitude:(double)latitude;
- (NSString *)getAddress;
@end
