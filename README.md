# phpSlideShowMaker
This is a automated video maker script in PHP. It uses a command line slideshow maker tools to make video from Images. Supports subtitle and some transactions. 

# DVD-Slideshow
The work is done by "DVD-Slideshow" app. To install it run

    apt-get install dvd-slideshow
To know more about it check [here](http://dvd-slideshow.sourceforge.net/index.php/Main_Page)
# Approach
The script makes a config file(video_desc) and load some configurations about the video to it. It gets the picture and others info using JSON. Then process the JSON and save the data in a temporary folder. Then it calls the binary file to process them and makes the video.
# To-Do
 There is nothing to do more. It was a test run for a bigger project. And it did its work enough. I am stopping it here. Maybe its broken or obsolete now.
 # Thanks
 Thanks to Mashpy Says vai to give me opportunity, help, knowledge and inspirations.
