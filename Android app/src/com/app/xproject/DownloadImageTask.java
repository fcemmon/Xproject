package com.app.xproject;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.URL;
import java.util.ArrayList;

import android.app.ProgressDialog;
import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.location.Address;
import android.os.AsyncTask;
import android.util.Log;
import android.widget.ImageView;

public class DownloadImageTask extends AsyncTask<Void, Void, Void> {

	public interface DoneImageDownload	{
		void onDoneImageDownload(boolean isDownload);
	}
	
	String url;
	ProgressDialog pd1;
	Bitmap currentImage;
	Context context;
	ImageView imageView;
	
	
	DoneImageDownload listener;
	
	DownloadImageTask(Context context, ImageView imageView, String imageUrl)	{
		this.context = context;
		this.url = imageUrl;
		this.imageView = imageView;
	}
	
    @Override
    protected Void doInBackground(Void... params) {
        // TODO Auto-generated method stub
        try {
        	URL imageURL = new URL(this.url);
	         this.currentImage = BitmapFactory.decodeStream(imageURL.openStream());
        } catch (Exception e) {
            // TODO: handle exception
            Log.e("error", "Downloading Image Failed");
            this.currentImage = null;
            e.printStackTrace();
        }
        return null;
    }
    @Override
    protected void onPostExecute(Void result) {
        // TODO Auto-generated method stub

    		if (this.currentImage == null) {
    			this.imageView.setImageBitmap(this.currentImage);
	        } else {
	            this.imageView.setImageResource(R.drawable.userprofile);
	        }
    	
    	pd1.dismiss();

    }  
    
    @Override
	protected void onPreExecute()
	{
	this.pd1 = ProgressDialog.show(this.context, "", "Image Loading...", true);
	super.onPreExecute();
	}
    
    public void setOnListener (DoneImageDownload listener) {
    	this.listener = listener;
	}
}