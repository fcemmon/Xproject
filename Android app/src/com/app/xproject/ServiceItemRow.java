package com.app.xproject;

import com.google.android.gms.location.LocationRequest;
import com.google.android.gms.maps.GoogleMap;

import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarActivity;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;

import java.io.InputStream;
import java.util.ArrayList;
import java.util.HashMap;
 


import com.koushikdutta.urlimageviewhelper.UrlImageViewCallback;
import com.koushikdutta.urlimageviewhelper.UrlImageViewHelper;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.util.EntityUtils;
import org.json.JSONObject;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.graphics.Bitmap;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.animation.OvershootInterpolator;
import android.view.animation.ScaleAnimation;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;
 
public class ServiceItemRow extends BaseAdapter {
 
    private Activity activity;
    private static LayoutInflater inflater=null;
    public ImageLoader imageLoader; 
    int currentPosition;
    ServiceDetails temp;
    boolean isHasImage;
 
    public ServiceItemRow(Activity _activity) {
        activity = _activity;
        inflater = (LayoutInflater)activity.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        isHasImage = false;
    }
 
    public int getCount() {
        return AppContants.services.size();
    }
 
    public Object getItem(int position) {
        return position;
    }
 
    public long getItemId(int position) {
        return position;
    }
 
    public View getView(int position, View convertView, ViewGroup parent) {
        View vi=convertView;
        if(convertView==null)
            vi = inflater.inflate(R.layout.servicedetailview, null);
 
        TextView serviceName = (TextView)vi.findViewById(R.id.servicNameView); // title
        ImageView thumb_image=(ImageView)vi.findViewById(R.id.serviceImageView); // thumb image
        if(AppContants.services.size() > position)	{
	       
        	temp = new ServiceDetails();
        	temp = AppContants.services.get(position);
        	serviceName.setText(temp.getServiceName());
        	
        	UrlImageViewHelper.setUrlDrawable(thumb_image, temp.service_image, R.drawable.userprofile, new UrlImageViewCallback() {
                				@Override
				public void onLoaded(ImageView imageView, Bitmap loadedBitmap,
						String url, boolean loadedFromCache) {
					// TODO Auto-generated method stub
                	if (!loadedFromCache) {
                		ScaleAnimation scale = new ScaleAnimation(0, 1, 0, 1, ScaleAnimation.RELATIVE_TO_SELF, .5f, ScaleAnimation.RELATIVE_TO_SELF, .5f);
                        scale.setDuration(300);
                        scale.setInterpolator(new OvershootInterpolator());
                        imageView.startAnimation(scale);
                    }
				}
            });
        }
        return vi;
    }
}