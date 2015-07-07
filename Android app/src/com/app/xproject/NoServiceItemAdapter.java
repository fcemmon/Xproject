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
 
public class NoServiceItemAdapter extends BaseAdapter {
 
    private Activity activity;
    private static LayoutInflater inflater=null;
    int currentPosition;
    NormalContactDetail temp;
 
    public NoServiceItemAdapter(Activity _activity) {
        activity = _activity;
        inflater = (LayoutInflater)activity.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
    }
 
    public int getCount() {
        return AppContants.noServiceContacts.size();
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
            vi = inflater.inflate(R.layout.noservicecontact_item, null);
 
        TextView serviceName = (TextView)vi.findViewById(R.id.contactName_noService); // title
 
        temp = new NormalContactDetail();
        
        // Setting all values in listview
        if(AppContants.noServiceContacts.size() > position)	{
        	temp = AppContants.noServiceContacts.get(position);
        	serviceName.setText(temp.contactName);
        }
        return vi;
    }
}