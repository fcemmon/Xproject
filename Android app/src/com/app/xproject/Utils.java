package com.app.xproject;

import java.io.InputStream;
import java.io.OutputStream;

public class Utils
{
  public static void CopyStream(InputStream paramInputStream, OutputStream paramOutputStream)
  {
    try
    {
      byte[] arrayOfByte = new byte[1024];
        int i = paramInputStream.read(arrayOfByte, 0, 1024);
        if (i == -1) {
          return;
        }
        paramOutputStream.write(arrayOfByte, 0, i);
    }
    catch (Exception localException) {}
  }
}
