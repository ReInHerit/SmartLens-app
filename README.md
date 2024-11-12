# ReInHerit SmartLens app

This application is part of the **ReInHerit Toolkit**.

![ReInHerit SmartLens logo](images/info/SmartLens-logo.jpg "ReInHerit SmartLens logo")

## Recognize details in artworks
This app allows the recognition of artworks and their details in images captured by the webcam of a smartphone in real time, showing the user the multimedia information related to them.
Details recognition is implemented using computer vision, applying three different methods:
* Retrieval using the MobileNet v3 Small network of Tensorflow.js
* Classification using the MobileNet v3 network on which fine-tuning has been performed on the dataset
* Object Detection using the SSD/MobileNetV3 network on which fine tuning has been performed for the recognition of the 
"objects" (details) of the works of the dataset.

## Installation
The application is implemented using HTML, CSS and JavaScript. It is necessary to have a web server to run it.
Artowrks and details info is stored in a MySQL database.
Update the `./server/config.php` file to connect to the database. 

## Compatibility
The application has been tested on the following mobile operating systems: Android (since v. 13) and iOS (up to 18.1), using the default browsers of each OS (i.e. Chrome and Safari). 

## Selecting the CV method
To select which CV method is used to recognize details (and thus how the interaction is implemented) it is necessary to uncomment one of the scripts at the bottom of the file camera-view.html.
* getDetailsObjDet.js for Object Detection

![Example of object detection](images/info/example1.png "Example of object detection")
![Example of object detection](images/info/example2.png "Example of object detection")
![Example of object detection](images/info/example3.png "Example of details info")


* getDetailsRetrieval for Retrieval
* getDetailsClass.js for Classification

### Retrieval
The CV method based on retrieval is implemented in the file getDetailsRetrieval.js.
There are two variants of the method, which adopt a different division of the images from which the features are extracted.
The version can be changed by modifying the value of the version variable at the beginning of the file getDetailsRetrieval.js.
* version = 1 : the Retrieval is applied to each frame with 5 images: the whole one taken from the webcam and 4 its parts 
obtained from a symmetric division without overlap.
* version = 2 : the Retrieval is applied to each frame with 6 images: in addition to the whole one, 5 its portions
of height and width equal to 2/3 of the measures of the original image are generated, arranged as in the figure
