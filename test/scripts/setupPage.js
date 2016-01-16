// JavaScript Document
/*
	Copyright (c) 2004 Duke University
  	Author: Justin Leonard
  	Released under the GNU General Public License
	
	Functions for finding the dimensions of the active page. These scripts are used to resize
	the page to fit better in the users window.
*/

/*
	Returns the height of the active window.
*/
function findActiveHeight()
{
	if(window.innerHeight != null)
		return window.innerHeight;
	if(document.body.clientHeight != null)
		return document.body.clientHeight;
	return null;
}

/*
	Changes the height of a element, based using the W3C's DOM and CSS style
*/

function changeHeight(elem, height)
{
	document.getElementById(elem).style.height = height + "px"; 
}

/*
	
	Finds the height of the window, then calculates appropriate sizes for the
	named components.
*/

function sizePage()
{
	windowHeight = findActiveHeight();
	
	if(windowHeight < 700)
	{
		windowHeight = 700;
	}

	windowHeight -= 20;

	contentHeight 	= windowHeight - 120;
	imageHeight		= windowHeight - 20;


	if(document.getElementById('Container')) changeHeight('Container', windowHeight);
	if(document.getElementById('Center')) changeHeight('Center', windowHeight);
	if(document.getElementById('ContentPane')) changeHeight('ContentPane', contentHeight);
	if(document.getElementById('MainText')) changeHeight('MainText', contentHeight);
	if(document.getElementById('Main')) changeHeight('Main', contentHeight);	
	if(document.getElementById('Left')) changeHeight('Left', contentHeight);
	if(document.getElementById('Right')) changeHeight('Right', windowHeight);
	document.getElementById('Container').style.visibility = "visible";		
}

function setMainColor(level)
{
	today = new Date;
	adder = 0;
	//divColor = new Array("#5A6C6D","#BB8822","#809583"); // winter, fall, spring
	divColor = new Array("#5A6C6D","#b4b600","#b48e00"); // winter, fall, spring
	// note: getMonth returns month from 0-11 0=Jan, 4=May, 8=March, 11=Dec
	if(today.getMonth() >= 4 && today.getMonth() < 8) adder = 2;
	else if(today.getMonth() >= 8 && today.getMonth() <= 11) adder = 1;
	if(document.getElementById('LeftPane')) {
		document.getElementById('LeftPane').style.backgroundColor = divColor[(adder+level)%divColor.length];
		document.getElementById('RightPane').style.backgroundColor = divColor[(adder+level+1)%divColor.length];
	}
	if(document.getElementById('Main')) document.getElementById('Main').style.backgroundColor = divColor[(adder+level)%divColor.length];
}