package com.app.xproject;

import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLConnection;
import java.util.ArrayList;

import android.app.ProgressDialog;
import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.AsyncTask;
import android.util.Log;
import android.widget.ImageView;

public class DownloadAsyncTask extends AsyncTask<Void, Void, Void> {
	
	ImageView imageView;
	ServiceDetails detail;
	ProgressDialog pd1;
	Bitmap currentImage;
	Context context;
	
	DownloadAsyncTask(Context context, ImageView imageView, ServiceDetails imageURL)	{
		this.imageView = imageView;
		this.detail = imageURL;
		this.imageView.setImageBitmap(null);
		this.context = context;
	}
	
    @Override
    protected Void doInBackground(Void... params) {
        // TODO Auto-generated method stub
    	
        try {
        	
            URL imageURL = new URL(this.detail.getServiceImage());
            this.currentImage = downloadImage(this.detail.service_image);
    		
        } catch (Exception e) {
            // TODO: handle exception
            Log.e("error", "Downloading Image Failed");
            this.currentImage = null;
        }
        return null;
    }
    @Override
    protected void onPostExecute(Void result) {
        // TODO Auto-generated method stub
    	pd1.dismiss();
        if (this.currentImage == null) {
            this.imageView.setImageResource(R.drawable.userprofile);
        } else {
            this.imageView.setImageBitmap(this.currentImage);
        }
        
        ServiceImageModel temp = new ServiceImageModel();
        temp.service_id = this.detail.service_id;
        temp.service_image = this.currentImage;
        AppContants.imageArray.add(temp);
    }  
    
    @Override
	protected void onPreExecute()
	{
    	super.onPreExecute();
    	this.pd1 = ProgressDialog.show(this.context, "", "Image Loading...", true);

	}
    
    private Bitmap downloadImage(String url) {
        Bitmap bitmap = null;
        InputStream stream = null;
        BitmapFactory.Options bmOptions = new BitmapFactory.Options();
        bmOptions.inSampleSize = 1;

        try {
            stream = getHttpConnection(url);
            bitmap = BitmapFactory.decodeStream(stream, null, bmOptions);

//          add on 12/02/2014
            bitmap = Bitmap.createScaledBitmap( // Out of memory exception
                    bitmap, (int) (bitmap.getWidth() * 0.8),
                    (int) (bitmap.getHeight() * 0.8), true);          

            stream.close();
        } catch (IOException e1) {
            Log.e("image download problem IO", e1.getMessage());
            e1.printStackTrace();
        }
        return bitmap;
    }




// Makes HttpURLConnection and returns InputStream
	private InputStream getHttpConnection(String urlString)
	        throws IOException {
	    InputStream stream = null;
	    URL url = new URL(urlString);
	    URLConnection connection = url.openConnection();
	
	    try {
	        HttpURLConnection httpConnection = (HttpURLConnection) connection;
	        httpConnection.setRequestMethod("GET");
	        httpConnection.connect();
	
	        if (httpConnection.getResponseCode() == HttpURLConnection.HTTP_OK) {
	            stream = httpConnection.getInputStream();
	        }
	    } catch (Exception ex) {
	        Log.e("image download problem", ex.getMessage());
	        ex.printStackTrace();
	    }
	    return stream;
	}
}