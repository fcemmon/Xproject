package com.app.xproject;

import com.google.android.gms.location.LocationRequest;
import com.google.android.gms.maps.GoogleMap;
import com.koushikdutta.urlimageviewhelper.UrlImageViewCallback;
import com.koushikdutta.urlimageviewhelper.UrlImageViewHelper;

import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarActivity;
import android.content.Intent;
import android.opengl.Visibility;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewDebug;
import android.widget.AdapterView;
import android.widget.ListView;

import java.io.InputStream;
import java.util.ArrayList;
import java.util.HashMap;
 







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
 
public class ViewerViewAdapter extends BaseAdapter {
 
	private Context mContext;
    private String imageURL;
    ImageLoader imageLoader;

      public ViewerViewAdapter(Context c) {
          mContext = c;
      }

      @Override
      public int getCount() {
          // TODO Auto-generated method stub
          return AppContants.viewerList.size();
      }

      @Override
      public Object getItem(int position) {
          // TODO Auto-generated method stub
          return null;
      }

      @Override
      public long getItemId(int position) {
          // TODO Auto-generated method stub
          return 0;
      }

      @Override
      public View getView(int position, View convertView, ViewGroup parent) {
          // TODO Auto-generated method stub
          View grid;
          LayoutInflater inflater = (LayoutInflater) mContext
              .getSystemService(Context.LAYOUT_INFLATER_SERVICE);

          if (convertView == null) {

              grid = new View(mContext);
              grid = inflater.inflate(R.layout.grid_single, null);
              ImageView imageView = (ImageView)grid.findViewById(R.id.grid_image);
              if(AppContants.viewerList.size() > 0)	{
            	  ViewerDetail temp = new ViewerDetail();
            	  temp = AppContants.viewerList.get(position);
              UrlImageViewHelper.setUrlDrawable(imageView, temp.getPhoto(), R.drawable.userprofile, new UrlImageViewCallback() {
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
          } else {
              grid = (View) convertView;
          }

          return grid;
      }
}