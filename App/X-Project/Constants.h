//
//  Constants.h
//  X-Project
//
//  Created by Admin on 6/2/15.
//  Copyright (c) 2015 admin. All rights reserved.
//

#import <Foundation/Foundation.h>

#pragma mark - SharedInstance

#define USER_INFO           @"user_info"
#define USER_TOKEN          @"user_token"
#define USER_ID             @"user_id"

#pragma mark - APIS

//#define mHostURL                        @"http://192.168.0.192/xappapi/"
#define mHostURL                        @"http://youserv.me/xappapi/"
#define mGetService                     @"services/getservices"
#define mOfferService                   @"services/offerservice"
#define mGetViewers                     @"services/getviewers"
#define mLikeService                    @"services/setlike"
#define mComment                        @"services/setcomment"
#define mSetFavorite                    @"services/setfavorite"
#define mContact                        @"services/getcontacts"

@interface Constants : NSObject

@end
