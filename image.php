<?php

class Image
{
    public function generateFilename($length)
    {
        $array = array(
            0, 1, 2, 3, 4, 5, 6, 7, 8, 9,
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J',
            'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',
            'U', 'V', 'W', 'X', 'Y', 'Z',
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j',
            'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't',
            'u', 'v', 'w', 'x', 'y', 'z'
        );
        $filename = "";


        for ($x =0; $x < $length; $x++)
        {
            $random = rand(0,61);//61 since thats how many values are in the array
            $filename .= $array[$random];
        }
        return $filename;
    }

    //create thumbnail for cover image
    public function getThumbCover($filename)
    {
       $thumbnail = $filename;// . "_cover_thumb.jpg";
       if (file_exists($thumbnail))
       {
           return $thumbnail;
       }
       $this->cropImage($filename,$thumbnail,1366,488);

       if (file_exists($thumbnail))
       {
           return $thumbnail;
       }
       else
       {
           return $filename;
       }
    }

    //create thumbnail for profile image
    public function getThumbProfile($filename)
    {
        $thumbnail = $filename;// . "_profile_thumb.jpg";
        if (file_exists($thumbnail))
        {
            return $thumbnail;
        }
        $this->cropImage($filename,$thumbnail,600,600);

        if (file_exists($thumbnail))
        {
            return $thumbnail;
        }
        else
        {
            return $filename;
        }

    }

    //create thumbnail for post image
/*
      public function getThumbPost($filename)
    {
        $thumbnail = $filename; //. "_post_thumb.jpg";

        if (file_exists($thumbnail))
        {
            return $thumbnail;
        }
        $this->cropImage($filename,$thumbnail,600,600);

        if (file_exists($thumbnail))
        {
            return $thumbnail;
        }
        else
        {
            return $filename;
        }
    }
*/

    //Resize the image
    public function getResize($origanal, $resized, $maxwidth, $maxheight)
    {
        if (file_exists($origanal))
        {
            $origanal_image = imagecreatefromjpeg($origanal);

            $origanal_width = imagesx($origanal_image);
            $origanal_height = imagesy($origanal_image);

            if($origanal_height > $origanal_width)
            {
                //make width equal to max width
                $ratio = $maxwidth / $origanal_width;

                $new_width = $maxwidth;
                $new_height = $origanal_height * $ratio;
            }
            else
            {
                //make height equal to max height
                $ratio = $maxheight / $origanal_height;

                $new_height = $maxheight;
                $new_width = $origanal_width * $ratio;
            }
        }

        //adjust incase max width and height r different
        if ($maxwidth != $maxheight)
        {
            if ($maxheight > $maxwidth)
            {
                if ($maxheight > $new_height)
                {
                    $adjust = ($maxheight / $new_height);
                }
                else
                {
                    $adjust = ($new_height / $maxheight);
                }

                $new_width = $new_width * $adjust;
                $new_height = $new_height * $adjust;
            }
            else
            {
                if ($maxwidth > $new_width)
                {
                    $adjust = ($maxwidth / $new_width);
                }
                else
                {
                    $adjust = ($new_width / $maxwidth);
                }

                $new_width = $new_width * $adjust;
                $new_height = $new_height * $adjust;
            }
        }

        $newImage = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($newImage, $origanal_image, 0, 0, 0, 0, $new_width, $new_height, $origanal_width, $origanal_height);

        imagedestroy($origanal_image);//destroy the origanl to save memory as dont want lots of image resources



        imagejpeg($newImage, $resized, 90);//save new cropped image
        imagedestroy($newImage);
    }


    public function cropImage($origanal, $cropped, $maxwidth, $maxheight)
    {
        if (file_exists($origanal))
        {
            $origanal_image = imagecreatefromjpeg($origanal);

            $origanal_width = imagesx($origanal_image);
            $origanal_height = imagesy($origanal_image);

            if($origanal_height > $origanal_width)
            {
                //make width equal to max width
                $ratio = $maxwidth / $origanal_width;

                $new_width = $maxwidth;
                $new_height = $origanal_height * $ratio;
            }
            else
            {
                //make height equal to max height
                $ratio = $maxheight / $origanal_height;

                $new_height = $maxheight;
                $new_width = $origanal_width * $ratio;
            }
        }

        //adjust incase max width and height r different
        if ($maxwidth != $maxheight)
        {
            if ($maxheight > $maxwidth)
            {
                if ($maxheight > $new_height)
                {
                    $adjust = ($maxheight / $new_height);
                }
                else
                {
                    $adjust = ($new_height / $maxheight);
                }

                $new_width = $new_width * $adjust;
                $new_height = $new_height * $adjust;
            }
            else
            {
                if ($maxwidth > $new_width)
                {
                    $adjust = ($maxwidth / $new_width);
                }
                else
                {
                    $adjust = ($new_width / $maxwidth);
                }

                $new_width = $new_width * $adjust;
                $new_height = $new_height * $adjust;
            }
        }

        $newImage = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($newImage, $origanal_image, 0, 0, 0, 0, $new_width, $new_height, $origanal_width, $origanal_height);

        imagedestroy($origanal_image);//destroy the origanl to save memory as dont want lots of image resources

        if ($maxwidth != $maxheight)
        {
            if ($maxwidth > $maxheight)
            {
                $difference = ($new_height - $maxheight);

                if ($difference < 0)
                {
                    $difference = $difference *-1;//multiplying by -1 so that the difference is always positive
                }

                $yaxis = round($difference / 2);
                $xaxis = 0;
            }
            else
            {
                $difference = ($new_width - $maxwidth);
                if ($difference < 0)
                {
                    $difference = $difference *-1;//multiplying by -1 so that the difference is always positive
                }
                $xaxis = round($difference / 2);
                $yaxis = 0;
            }
        }
        else
        {
            if ($new_height > $new_width)
            {
                $difference = ($new_height - $new_width);
                $yaxis = round($difference / 2);
                $xaxis = 0;
            }
            else
            {
                $difference = ($new_width - $new_height);
                $xaxis = round($difference / 2);
                $yaxis = 0;
            }
        }


        $new_cropped = imagecreatetruecolor($maxwidth, $maxheight);
        imagecopyresampled($new_cropped, $newImage, 0, 0, $xaxis, $yaxis, $maxwidth, $maxheight, $maxwidth, $maxheight);
        imagedestroy($newImage);

        imagejpeg($new_cropped, $cropped, 90);//save new cropped image
        imagedestroy($new_cropped);
    }
}
?>
