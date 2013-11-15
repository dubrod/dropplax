#AutoDLC ( revitalagency.github.io/autoDLC/ )

##File Structure
- galleries
	- "galleryname"
		- tns
		- photos

##Upload your photos and thumbnails inside your unique gallery named folder
*.jpg files only*
*thumbnails look best at 150px high*

##Add 7th Variable your Post 
`- galleryname`
goes after
`- published`

##Add 8th Variable your Post 
`- intro text here`
goes after
`- galleryname`

##Add this to your article where you want the gallery to appear

`<div id="autoDLC"></div>`

##.htaccess file
Make sure you have copied the .htaccess file for the "galleries" folder or this will not work.
`RewriteEngine off
Options +Indexes`