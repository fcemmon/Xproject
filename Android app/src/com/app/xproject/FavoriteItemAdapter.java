package com.app.xproject;

import com.google.android.gms.location.LocationRequest;
import com.google.android.gms.maps.GoogleMap;

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
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;
 
public class FavoriteItemAdapter extends BaseAdapter {
 
    private Activity activity;
    private static LayoutInflater inflater=null;
    int currentPosition;
    ContactDetail temp;
 
    public FavoriteItemAdapter(Activity _activity) {
        activity = _activity;
        inflater = (LayoutInflater)activity.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
    }
 
    public int getCount() {
        return AppContants.serviceContactList.size();
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
            vi = inflater.inflate(R.layout.servicecontact_item, null);
 
        TextView serviceName = (TextView)vi.findViewById(R.id.contactName_Service); // title
        ImageView thumb_image=(ImageView)vi.findViewById(R.id.favorite_Service); // thumb image
 
        temp = new ContactDetail();
        
        // Setting all values in listview
        if(AppContants.serviceContactList.size() > position)	{
        	temp = AppContants.serviceContactList.get(position);
        	serviceName.setText(temp.contactName);
        	if(temp.favorite.equals("")||temp.favorite.equals("0"))
        		thumb_image.setVisibility(View.INVISIBLE);
        	else
        		thumb_image.setVisibility(View.VISIBLE);
        }
        return vi;
    }
}