//Youmax + PhotoMax - http://codecanyon.net/item/youmax-youtube-vimeo-facebook-instagram-grid/9989505

//var photomaxLoggedInUser = {};
var layoutResizeTimer;
//var $photomaxGrid;
//var photomaxReloadCount = 1;

(function ($) {


	//get photos of any user using instagram API
	var getInstagramUserPhotos = function (userId,tabId,nextPageUrl,$photomaxContainer) {
		//console.log('inside getUserPhotos');
		var loadMoreFlag = false, createFlag = true, paginateFlag = false;
		
		//console.log($photomaxContainer);
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');

		if(null!=nextPageUrl && nextPageUrl!="") {
			apiUserPhotosURL = nextPageUrl;
			loadMoreFlag = true;
			createFlag = false;
		} else {
			apiUserPhotosURL = "https://api.instagram.com/v1/users/"+userId+"/media/recent?count="+photomax_global_options.maxResultsToLoad+"&access_token="+photomax_global_options.instagramAccessToken;
		}
		
		if(photomax_global_options.loadMode.indexOf("paginate")!=-1 && loadMoreFlag) {
			loadMoreFlag = false;
			paginateFlag = true;
		}		

		
		//console.log('getInstagramUserPhotos apiUserPhotosURL-'+apiUserPhotosURL);
		
		$.ajax({
			url: apiUserPhotosURL,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'jsonp',
			success: function(response) {
				updateCache('instagram',response,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag,tabId);
			},
			error: function(html) { alert(html); },
			beforeSend: setHeader
		});
	},

	//get photos of any user using instagram API
	getInstagramUserTaggedPhotos = function (userTagPair,tabId,nextPageUrl,$photomaxContainer) {
		//console.log('inside getUserPhotos');
		var loadMoreFlag = false, createFlag = true, paginateFlag = false;
		
		//console.log($photomaxContainer);
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');

		//userTagPair = userTagPair.split('_');
		
		var userId = userTagPair.substring(0,userTagPair.indexOf('_'));
		var hashTag = userTagPair.substring(userTagPair.indexOf('_')+1).replace(/\s+/g,' ');

		//console.log('-------------'+$photomaxContainer.attr('id')+'-------------');
		//console.log('getInstagramUserTaggedPhotos');
		//console.log(hashTag);
		
		if(null!=nextPageUrl && nextPageUrl!="") {
			apiUserPhotosURL = nextPageUrl;
			loadMoreFlag = true;
			createFlag = false;
		} else {
			apiUserPhotosURL = "https://api.instagram.com/v1/users/"+userId+"/media/recent?count="+photomax_global_options.maxResultsToLoad+"&access_token="+photomax_global_options.instagramAccessToken;
		}
		
		if(photomax_global_options.loadMode.indexOf("paginate")!=-1 && loadMoreFlag) {
			loadMoreFlag = false;
			paginateFlag = true;
		}		
		
		//console.log('getUserPhotos apiUserPhotosURL-'+apiUserPhotosURL);
		
		$.ajax({
			url: apiUserPhotosURL,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'jsonp',
			success: function(response) { 
				updateCache('instagram',response,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag,tabId,hashTag);
			},
			error: function(html) { alert(html); },
			beforeSend: setHeader
		});
	},
	
	getInstagramGlobalTaggedPhotos = function (hashTag,tabId,nextPageUrl,$photomaxContainer) {
		//console.log('inside getUserPhotos');
		var loadMoreFlag = false, createFlag = true, paginateFlag = false;
		
		//console.log($photomaxContainer);
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');

		if(null!=nextPageUrl && nextPageUrl!="") {
			apiUserPhotosURL = nextPageUrl;
			loadMoreFlag = true;
			createFlag = false;
		} else {
			apiUserPhotosURL = "https://api.instagram.com/v1/tags/"+hashTag+"/media/recent?count="+photomax_global_options.maxResultsToLoad+"&access_token="+photomax_global_options.instagramAccessToken;
		}
		
		if(photomax_global_options.loadMode.indexOf("paginate")!=-1 && loadMoreFlag) {
			loadMoreFlag = false;
			paginateFlag = true;
		}		
		
		//console.log('getUserPhotos apiUserPhotosURL-'+apiUserPhotosURL);
		
		$.ajax({
			url: apiUserPhotosURL,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'jsonp',
			success: function(response) {
				updateCache('instagram',response,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag,tabId);
			},
			error: function(html) { alert(html); },
			beforeSend: setHeader
		});
	},
	
	
	//get photos of any album using picasa API
	getGoogleAlbumPhotos = function (albumUserPair,tabId,startIndex,$photomaxContainer) {
		//console.log('inside getGoogleAlbumPhotos');
		var loadMoreFlag = false, createFlag = true, paginateFlag = false;
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');

		//console.log('getGoogleAlbumPhotos startIndex-'+startIndex);
		if(null==startIndex||startIndex=="") {
			startIndex = 1;
		} else if(startIndex>1) {
			loadMoreFlag = true;
			createFlag = false;
		}

		if(photomax_global_options.loadMode.indexOf("paginate")!=-1 && loadMoreFlag) {
			loadMoreFlag = false;
			paginateFlag = true;
		}		
		
		s = albumUserPair.indexOf("_");
		albumId = albumUserPair.substring(0,s);
		userId = albumUserPair.substring(s+1);

		apiAlbumPhotosURL = "https://picasaweb.google.com/data/feed/api/user/"+userId+"/albumid/"+albumId+"?start-index="+startIndex+"&max-results="+photomax_global_options.maxResultsToLoad+"&v=2&alt=json";
		
		//console.log('getGoogleAlbumPhotos apiAlbumPhotosURL-'+apiAlbumPhotosURL);
		
		$.ajax({
			url: apiAlbumPhotosURL,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'jsonp',
			success: function(response) { 
				updateCache('google',response,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag,tabId);
			},
			error: function(html) { alert(html); },
			beforeSend: setHeader
		});
	},
	

	

	//get Google User Photos using picasa API
	getGoogleUserAlbums = function (userId,tabId,startIndex,$photomaxContainer) {
		//console.log('inside getGoogleUserAlbums');
		var loadMoreFlag = false, createFlag = true, paginateFlag = false;
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');

		//console.log('getGoogleUserAlbums startIndex-'+startIndex);
		if(null==startIndex||startIndex=="") {
			startIndex = 1;
		} else if(startIndex>1) {
			loadMoreFlag = true;
			createFlag = false;
		}

		if(photomax_global_options.loadMode.indexOf("paginate")!=-1 && loadMoreFlag) {
			loadMoreFlag = false;
			paginateFlag = true;
		}		
		
		apiAlbumPhotosURL = "https://picasaweb.google.com/data/feed/api/user/"+userId+"?kind=album&start-index="+startIndex+"&max-results=100&v=2&alt=json&access=public";
		
		//photomax_global_options.maxResults

		//save the last viewed playlist for back button
		$photomaxContainer.data('photomax_last_channel_playlists',tabId);
		//console.log('getGoogleUserPhotos apiAlbumPhotosURL-'+apiAlbumPhotosURL);
		
		$.ajax({
			url: apiAlbumPhotosURL,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'jsonp',
			success: function(response) {
				updateCache('google',response,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag,tabId);
			},
			error: function(html) { alert(html); },
			beforeSend: setHeader
		});
	},
	

	//get Google User Photos using picasa API
	getGoogleUserPhotos = function (userId,tabId,startIndex,$photomaxContainer) {
		//console.log('inside getGoogleUserPhotos');
		var loadMoreFlag = false, createFlag = true, paginateFlag = false;
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');

		//console.log('getGoogleUserPhotos startIndex-'+startIndex);
		if(null==startIndex||startIndex=="") {
			startIndex = 1;
		} else if(startIndex>1) {
			loadMoreFlag = true;
			createFlag = false;
		}

		if(photomax_global_options.loadMode.indexOf("paginate")!=-1 && loadMoreFlag) {
			loadMoreFlag = false;
			paginateFlag = true;
		}		
		
		apiAlbumPhotosURL = "https://picasaweb.google.com/data/feed/api/user/"+userId+"?kind=photo&start-index="+startIndex+"&max-results=100&v=2&alt=json&access=public";
		
		//photomax_global_options.maxResults

		
		//console.log('getGoogleUserPhotos apiAlbumPhotosURL-'+apiAlbumPhotosURL);
		
		$.ajax({
			url: apiAlbumPhotosURL,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'jsonp',
			success: function(response) {
				updateCache('google',response,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag,tabId);
			},
			error: function(html) { alert(html); },
			beforeSend: setHeader
		});
	},
		
	
	//get photo stats using Picasa API
	getGooglePhotoStats = function (photoIdList,userId,$photomaxContainer) {
		//console.log('inside getPhotoStats');
		//console.log(photoIdList);
		//showLoader();
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		var apiPhotoStatURL,albumId,photoId,s;
		
		
		for(var p=0;p<photoIdList.length;p++) {
			s = photoIdList[p].indexOf("_");
			albumId = photoIdList[p].substring(0,s);
			photoId = photoIdList[p].substring(s+1);
			apiPhotoStatURL = "https://picasaweb.google.com/data/feed/api/user/"+userId+"/albumid/"+albumId+"/photoid/"+photoId+"?alt=json&v=2";
			$.ajax({
				url: apiPhotoStatURL,
				type: "GET",
				async: true,
				cache: true,
				dataType: 'jsonp',
				success: function(response) { displayGooglePhotoStats(response,$photomaxContainer);},
				error: function(html) { alert(html); },
				beforeSend: setHeader
			});
		}
	},

	//display photo statistics
	displayGooglePhotoStats = function(response,$photomaxContainer) {
		//console.log(response);
		
		var photomax_translator_text = $photomaxContainer.data('photomax_translator_text');
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		
		var photoArray = response.items;
		var $photoThumbnail;

		photoId = response.feed.gphoto$id.$t;
		photoViewCount_raw = response.feed.gphoto$viewCount;
		if(null!=photoViewCount_raw) {
			photoViewCount_raw = photoViewCount_raw.$t;
			photoViewCount = convertViewCountForThumbnail(photoViewCount_raw);
		} else {
			return;
		}
		
		
		//Cannot find HD/SD via the API
		//photoDefinition = photoArray[i].contentDetails.definition.toUpperCase();
		
		$photoThumbnail = $photomaxContainer.find('#photomax-video-list-div #google_'+photoId);
		
		$photoThumbnail.data('views',photoViewCount);
		$photoThumbnail.attr('data-views',photoViewCount);
		
		viewString = '<span class="photomax-video-list-views" title="views"><span class="photomax-list-thumbnail-icon"><i class="fa fa fa-dot-circle-o"></i></span> <span class="photomax-all-skin-views">' + photoViewCount+'</span> <span class="photomax-views-text">'+photomax_translator_text.views+'</span></span>';
		
		//console.log('photoViewCount_raw: '+photoViewCount_raw);
		//console.log('photoViewCount: '+photoViewCount);

		photoUploaded = $photoThumbnail.data('photouploaded');
		timeInMs = Math.abs(new Date() - new Date(photoUploaded));
		
		trend = getVideoTrend(photoViewCount_raw,0,0,timeInMs,photomax_global_options.hotThreshold,photomax_global_options.trendingThreshold);
		
		if(trend=="trending") {
			icon="fa-bolt";
		} else if (trend=="hot") {
			icon="fa-fire";
		} else {
			icon="fa-check";
		}
		
		trendString = '<span class="photomax-trend-holder photomax-'+trend+'"><i class="fa '+icon+'"></i> <span class="photomax-trend-text">'+trend+'</span></span>';
		
		
		$photoThumbnail.find('.photomax-trend-holder').remove();
		$photoThumbnail.find('.photomax-trend-link-holder').prepend(trendString);
		$photoThumbnail.find('.photomax-view-date-holder').prepend(viewString);

		//overlay styles
		if(photomax_global_options.overlayType=='stat-1' || photomax_global_options.overlayType=='stat-2') {
			if(photoViewCount_raw>0) {
				$photoThumbnail.find('.photomax-play-icon-holder').addClass('photomax-overlay-stat').empty().append('<i class="fa fa fa-dot-circle-o"></i><span class="photmax-overlay-stat-text">'+photoViewCount+'</span>');
			}
		}
		
		
		if(photomax_global_options.overlayType=='stat-1-desc' || photomax_global_options.overlayType=='stat-2-desc') {
			if(photoViewCount_raw>0) {
				$photoThumbnail.find('.photomax-play-icon-holder').prepend('<div class="photomax-overlay-stat"><i class="fa fa-dot-circle-o"></i><span class="photmax-overlay-stat-text">'+photoViewCount+'</span></div>');
			}
		}
		
		
		
		
		
	},	
	
	//get photos from Facebook album
	getFacebookAlbumPhotos = function (albumId,tabId,nextPageApiUrl,$photomaxContainer) {
		//console.log('inside getPlaylistVideos');
		//var pageTokenUrl = "";
		var loadMoreFlag = false, createFlag = true, paginateFlag = false;

		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		
		if(null==nextPageApiUrl) {
			apiUrl = "https://graph.facebook.com/v2.4/"+albumId+"/photos?limit="+photomax_global_options.maxResultsToLoad+"&access_token="+photomax_global_options.facebookAccessToken+"&fields=id,images,link,name,picture,source,comments.limit(1).summary(true),likes.limit(1).summary(true),shares,created_time";
		} else {
			apiUrl = nextPageApiUrl;
			loadMoreFlag = true;
			createFlag = false;
		}

		if(photomax_global_options.loadMode.indexOf("paginate")!=-1 && loadMoreFlag) {
			loadMoreFlag = false;
			paginateFlag = true;
		}		
		
		//console.log('getFacebookAlbumPhotos apiUrl-'+apiUrl);
		
		$.ajax({
			url: apiUrl,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'jsonp',
			success: function(response) { 
				updateCache('facebook',response,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag,tabId);			
			},
			error: function(errorResponse) {  alert(errorResponse); },
			beforeSend: setHeader
		});
	},
	
	//process message text
	getProcessedMessage = function(message,isComment) {
	
		if(null==message) {
			message = "";
			return message;
		}
		
		if(null==isComment || isComment==false) {
			//wrap links
			spotArray = message.match(/http(s)*:\/\/.+?(\s|\n|$)/g);
			//console.log(message);
			//console.log(spotArray);
			if(null!=spotArray) {
				for(var i=0;i<spotArray.length;i++) {
					spotArray[i] = spotArray[i].trim();
					message = message.replace(spotArray[i],"<a target='_blank' href='"+spotArray[i]+"' class='famax-link'>"+spotArray[i]+"</a>");
					//use if hashtags are also being processed
					//replaceText = spotArray[i].replace('#',':hash:');
					//message = message.replace(spotArray[i],'<a target="_blank" href="'+replaceText+'" class="famax-link">'+replaceText+'</a>');
				}
			}
		}
		/*
		//TODO: wrap hashtags in future version
		spotArray = message.match(/#(\w|\d)+/g);
		//console.log(message);
		//console.log(spotArray);
		if(null!=spotArray) {
			for(var i=0;i<spotArray.length;i++) {
				message = message.replace(spotArray[i],'<span class="famax-link">'+spotArray[i]+'</span>');
			}
		}
		*/
		
		
		//message = message.replace(/:hash:/g,'#');
		
		//4.0 added 
		message = message.replace(/\n/g,"<br>");

		return message;
	
	},
	
	//extract picture for album
	extractPhotoImage = function(feed) {
		
		var picture;
		//console.log('extractVideoThumbnail-');
		//console.log(feed);

		for(var k=0,l=feed.images.length-1;k<l;k++) {
			picture = feed.images[k].source;
			width = feed.images[k].width;
			
			if(width<=900) break;
		
		}

		return picture;

		/*
		pictureArray = feed.images;
		picture = pictureArray[0].source;
		return picture;*/

	},


	//get photos of a Fan Page
	getFacebookPagePhotos = function (pageId,tabId,nextPageApiUrl,$photomaxContainer) {
		//console.log('inside getPlaylistVideos');
		//var pageTokenUrl = "";
		var loadMoreFlag = false, createFlag = true, paginateFlag = false;
		
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		
		if(null==nextPageApiUrl) {
			apiUrl = "https://graph.facebook.com/v2.4/"+pageId+"/photos/uploaded?limit="+photomax_global_options.maxResultsToLoad+"&access_token="+photomax_global_options.facebookAccessToken+"&fields=id,images,link,name,picture,source,comments.limit(1).summary(true),likes.limit(1).summary(true),shares,created_time";
			//"&fields=id,description,embed_html,name,picture,length,source,status,link,thumbnails,format,comments.limit(1).summary(true),likes.limit(1).summary(true),shares";
		} else {
			apiUrl = nextPageApiUrl;
			loadMoreFlag = true;
			createFlag = false;
		}


		if(photomax_global_options.loadMode.indexOf("paginate")!=-1 && loadMoreFlag) {
			loadMoreFlag = false;
			paginateFlag = true;
		}		
		
		//console.log('getPagePhotos apiUrl-'+apiUrl);
		
		$.ajax({
			url: apiUrl,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'jsonp',
			success: function(response) { 
				updateCache('facebook',response,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag,tabId);			
			},
			error: function(errorResponse) {  alert(errorResponse); },
			beforeSend: setHeader
		});
	},
	


	//get albums of a Fan Page
	getFacebookPageAlbums = function (pageId,tabId,nextPageApiUrl,$photomaxContainer) {
		//console.log('inside getPlaylistVideos');
		//var pageTokenUrl = "";
		var loadMoreFlag = false, createFlag = true, paginateFlag = false;
		
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		
		if(null==nextPageApiUrl) {
			apiUrl = "https://graph.facebook.com/v2.4/"+pageId+"/albums?limit="+photomax_global_options.maxResultsToLoad+"&access_token="+photomax_global_options.facebookAccessToken+"&fields=id,link,name,cover_photo,count,created_time";

			//"&fields=id,description,embed_html,name,picture,length,source,status,link,thumbnails,format,comments.limit(1).summary(true),likes.limit(1).summary(true),shares";
		} else {
			apiUrl = nextPageApiUrl;
			loadMoreFlag = true;
			createFlag = false;
		}


		if(photomax_global_options.loadMode.indexOf("paginate")!=-1 && loadMoreFlag) {
			loadMoreFlag = false;
			paginateFlag = true;
		}		

		//save the last viewed playlist for back button
		$photomaxContainer.data('photomax_last_channel_playlists',tabId);
		
		//console.log('getPagePhotos apiUrl-'+apiUrl);
		
		$.ajax({
			url: apiUrl,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'jsonp',
			success: function(response) { 
				updateCache('facebook',response,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag,tabId);			
			},
			error: function(errorResponse) {  alert(errorResponse); },
			beforeSend: setHeader
		});
	},


	getAlbumCoverPhotos = function (coverPhotoIdArray,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag,$items) {
		//console.log('inside getPlaylistVideos');
		//var pageTokenUrl = "";
		
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		
		//var pageId = $photomaxContainer.find('.photomax-tab.photomax-tab-hover').attr('id').substring(21);
		
		if(null==coverPhotoIdArray || coverPhotoIdArray.length==0) {
			return;
		}
		
		apiUrl = "https://graph.facebook.com/v2.4/?ids="+coverPhotoIdArray+"&access_token="+photomax_global_options.facebookAccessToken+"&fields=id,images";
		//console.log('getAlbumCoverPhotos apiUrl-'+apiUrl);
		
		$.ajax({
			url: apiUrl,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'jsonp',
			success: function(response) { insertAlbumCoverPhotos(response,coverPhotoIdArray,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag,$items);},
			error: function(errorResponse) {  alert(errorResponse); },
			beforeSend: setHeader
		});
	},	
	
	

	//insert album details
	insertAlbumCoverPhotos = function(response,coverPhotoIdArray,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag,$items) {
		//console.log('insertAlbumCoverPhotos');
		//console.log(response);
		
		//regenerate acceess Token if expired
		if(response.error!=null) {
			if(response.error.code==190 && response.error.message.indexOf('expired')!=-1) {
				alert('Session expired. Please reload the page.');
			}
		}

		
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		//var $photomaxContainerList = $photomaxContainer.find('ul');


		//alert(videoArray.length);
		for(var i=0; i<coverPhotoIdArray.length; i++) {
			
			photoId = coverPhotoIdArray[i];		
			
			//postMainImage = $photomaxContainer.find('#photomax-video-list-div .'+photoId);	
			postMainImage = $items.find('.'+photoId);	
			//console.log('postMainImage href-'+postMainImage.attr('src'));
			
			picture = extractAlbumImage(response[photoId]);
			
			/*
			//added in v5
			if(response[photoId].images.length>1) {
				ldPicture = response[photoId].images[response[photoId].images.length-2].source;
			} else {
				ldPicture = picture;
			}*/
			
			postMainImage.attr('data-hdpicture',picture);
			
			//console.log('picture-'+picture);

			if(postMainImage.is("img")) {
				postMainImage.attr('src',picture);
			} else {
				postMainImage.css('background-image','url('+picture+')');	
			}
			

		}
		//alert('done fixing..');
		

		createGrid($photomaxContainer,"album",createFlag,loadMoreFlag,paginateFlag,$items);

		
		/*
		//added in v5 - create grid here 
		window.clearTimeout(famaxRefreshTimer);
		famaxRefreshTimer = setTimeout(function(){createGrid(null,$famaxContainer,null,null,null,true);}, famax_global_options.refreshTimeout);		
*/
		
		
	

		
		
	},
	

	//extract picture for album
	extractAlbumImage = function(feed) {
		
		var picture;
		//console.log('extractVideoThumbnail-');
		//console.log(feed);

		for(var k=0,l=feed.images.length-1;k<l;k++) {
			picture = feed.images[k].source;
			width = feed.images[k].width;
			
			if(width<=400) break;
		
		}

		return picture;

		/*
		pictureArray = feed.images;
		picture = pictureArray[0].source;
		return picture;*/

	},
	
		
	//get Fan Page details
	getFacebookUserDetails = function (pageId,tabId,$photomaxContainer) {
		//console.log('inside getChannelDetails');
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		
		apiUrl = "https://graph.facebook.com/v2.4/"+pageId+"?access_token="+photomax_global_options.facebookAccessToken+"&fields=talking_about_count,cover,likes,name,link,picture";
		//console.log('apiUrl-'+apiUrl);
		//showLoader();
		
		$.ajax({
			url: apiUrl,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'jsonp',
			success: function(response) { 
				//console.log(response);
				userName = response.name;
				userImage = response.picture.data.url;
				userLink = response.link;
				

				$tab = $photomaxContainer.find('#'+tabId);
				
				$tab.data('username',userName);
				$tab.data('userimage',userImage);
				$tab.data('userlink',userLink);
				
			},
			error: function(html) { alert(html); },
			beforeSend: setHeader
		});
	},
	

		
	//get Instagram details
	getInstagramUserDetails = function (userId,tabId,$photomaxContainer) {
		//console.log('inside getInstagramUserDetails : '+tabId+" | "+userId);
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		
		apiUrl = "https://api.instagram.com/v1/users/"+userId+"?access_token="+photomax_global_options.instagramAccessToken+"&count=1";

		//console.log('apiUrl-'+apiUrl);
		//showLoader();
		
		$.ajax({
			url: apiUrl,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'jsonp',
			success: function(response) {
				//console.log(response);
				userName = response.data.full_name;
				userImage = response.data.profile_picture;
				userLink = "https://instagram.com/" + response.data.username;
				

				$tab = $photomaxContainer.find('#'+tabId);
				
				$tab.data('username',userName);
				$tab.data('userimage',userImage);
				$tab.data('userlink',userLink);
				
			},
			error: function(html) { alert(html); },
			beforeSend: setHeader
		});
	},
	

		
	//get Google details
	getGoogleUserDetails = function (userId,tabId,$photomaxContainer) {
		//console.log('inside getGoogleUserDetails');
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		
		apiUrl = "https://www.googleapis.com/plus/v1/people/"+userId+"?key="+photomax_global_options.googleApiKey;

		//console.log('apiUrl-'+apiUrl);
		//showLoader();
		
		$.ajax({
			url: apiUrl,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'jsonp',
			success: function(response) {
				//console.log(response);
				userName = response.displayName;
				userImage = response.image.url;
				userLink = response.url;
				userId = response.id;

				$tab = $photomaxContainer.find('#'+tabId);
				
				$tab.data('username',userName);
				$tab.data('userimage',userImage);
				$tab.data('userlink',userLink);
				$tab.data('userid',userId);

			},
			error: function(html) { alert(html); },
			beforeSend: setHeader
		});
	},
	


	
	
	
	
	
	
	
	
	
	
	
	
	
	//display youtube subscribe button
	renderSubscribeButton = function() {
	
		$.ajaxSetup({
		  cache: true
		});
		
		$.getScript("https://apis.google.com/js/platform.js")
		.done(function( script, textStatus ) {
			//alert( textStatus );
		})
		.fail(function( jqxhr, settings, exception ) {
			//alert( "Triggered ajaxError handler." );
		});
		

		
	},
	
	
	//initialize youamx - add necessary HTML code
	initPhotomax = function($photomaxContainer) {
	
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		
		//Empty the container - ajax compatibility
		$photomaxContainer.empty();
		
		//header + added in 6.0 - search!!
		$photomaxContainer.append('<div id="photomax-header"><div id="photomax-header-wrapper"></div></div>');
		
		//tabs
		$photomaxContainer.append('<div id="photomax-tabs"></div>');
				
		//select
		$photomaxContainer.append('<div id="photomax-select-box"><select id="photomax-select"></select><i class="fa fa-caret-down"></i></div>');
		
		/*
		//top ad space
		if(photomax_global_options.showTopAdSpace) {
			//console.log("showing ad");
			//console.log($photomaxContainer.find('#photomax-top-ad'));
			//$photomaxTopAd =  $photomaxContainer.find('#photomax-top-ad').wrap('<div class="photomax-ad-space">');
			$photomaxContainer.append('<div class="photomax-ad-space">'+photomax_global_options.topAdHtml+'</div>');		
		}*/
		
		
		//showing album xxxx
		$photomaxContainer.append('<div id="photomax-showing-title"></div>');
		
		//list
		var videoListClass = "";
		if(photomax_global_options.loadMode=="paginate-sides") {
			videoListClass = "photomax-small-container";
		}		
		$photomaxContainer.append('<div id="photomax-video-list-div" class="'+videoListClass+'"><ul id="tiles"></ul></div>');

		var $photomaxLoadMoreDiv = null, $photomaxPreviousDiv = null, $photomaxNextDiv = null;
		var buttonClass = '';
		
		if(photomax_global_options.loadButtonSize=="small") {
			buttonClass = 'class="photomax-small"';
		}
		
		if(photomax_global_options.loadMode=="loadmore") {
			//load more
			$photomaxContainer.append('<button type="button" id="photomax-load-more-div" '+buttonClass+'></button>');
			$photomaxLoadMoreDiv = $photomaxContainer.find('#photomax-load-more-div');
		} else if(photomax_global_options.loadMode=="paginate-bottom") {
			//pagination
			$photomaxContainer.append('<div class="photomax-pagination"><div class="photomax-pagination-button-wrapper photomax-left-wrapper"><button type="button" id="photomax-previous-div" '+buttonClass+'></button></div><div class="photomax-pagination-button-wrapper photomax-right-wrapper"><button type="button" id="photomax-next-div" '+buttonClass+'></button></div></div>');
			$photomaxNextDiv = $photomaxContainer.find('#photomax-next-div');
			$photomaxPreviousDiv = $photomaxContainer.find('#photomax-previous-div');
		}  else if(photomax_global_options.loadMode=="paginate-sides") {
			//pagination
			$photomaxContainer.append('<div class="photomax-pagination-button-wrapper photomax-left-wrapper photomax-side-nav"><button type="button" id="photomax-previous-div" '+buttonClass+'></button></div><div class="photomax-pagination-button-wrapper photomax-right-wrapper photomax-side-nav"><button type="button" id="photomax-next-div" '+buttonClass+'></button></div>');
			$photomaxNextDiv = $photomaxContainer.find('#photomax-next-div');
			$photomaxPreviousDiv = $photomaxContainer.find('#photomax-previous-div');
		} 
		
		resetLoadMoreButton($photomaxContainer);
		
		if(null!=$photomaxLoadMoreDiv) {
			$photomaxLoadMoreDiv.data('nextpagetoken','');
			$photomaxLoadMoreDiv.click(function(){
				//loadMoreItems($photomaxContainer);
				paginationWrapper($photomaxContainer,"more");
				
			});
		}
		
		if(null!=$photomaxPreviousDiv) {
			$photomaxPreviousDiv.click(function(){
				paginationWrapper($photomaxContainer,"previous");
				//handlePagination($photomaxContainer,"previous");
			});
		}
		
		if(null!=$photomaxNextDiv) {
			$photomaxNextDiv.click(function(){
				paginationWrapper($photomaxContainer,"next");
				//handlePagination($photomaxContainer,"next");
			});
		}
		
		
		$photomaxContainer.find('#photomax-tabs').on('click','.photomax-tab',function() {
			$photomaxContainer.find('#photomax-load-more-div').removeAttr('disabled');
			displayItems(this.id,$photomaxContainer);
		});
		
		$photomaxContainer.find('#photomax-select').change(function() {
			var itemId = $(this).find(":selected").val();
			displayItems(itemId,$photomaxContainer);
		});
		
		//5.0 - show comments
		/*$photomaxContainer.find('.photomax-encloser-comment-button.photomax-show-button').click(function(){
			displayComments(this.id,$photomaxContainer);
		});	
		$photomaxContainer.find('.photomax-encloser-comment-button.photomax-more-button').click(function(){
			loadMoreComments($photomaxContainer);
		});	*/
		
		if(photomax_global_options.displayType=="popup") {
			$photomaxPlayBox = $('body');
			$photomaxPlayBox.off('click','.photomax-show-button');
			$photomaxPlayBox.off('click','.photomax-add-comment-button');
		} else {
			$photomaxPlayBox = $photomaxContainer;
		}
		
		/*$photomaxPlayBox.on('click','.photomax-show-button',function(){
			displayComments(this.id,$photomaxContainer);
		});
		
		$photomaxPlayBox.on('click','.photomax-more-button',function(){
			loadMoreComments($photomaxContainer);
		});*/
		
		
		/*
		//added in 6.0 
		$photomaxContainer.on('keyup','#photomax-search-box,#photomax-search-box-header', function (e) {
			if (e.keyCode == 13) {
				searchText = "query_" + $(this).val();
				displayItems(searchText,$photomaxContainer);
				return false;
			}
		});
		*/
		

		$photomaxContainer.on('mouseenter','.photomax-thumbnail-image-wrapper',function(){
			$(this).find(".photomax-play-overlay").show();
		});

		$photomaxContainer.on('mouseleave','.photomax-thumbnail-image-wrapper',function(){
			$(this).find(".photomax-play-overlay").hide();
		});

		
		$photomaxContainer.on('click','#photomax-back-to-playlists',function(){
			//alert('back');
			var lastPlaylistsTabId = $photomaxContainer.data('photomax_last_channel_playlists');
			$photomaxContainer.find('#'+lastPlaylistsTabId).click();
		});
		
		/*
		$photomaxContainer.on('click','#photomax-search-holder-header',function(){
			$(this).find('#photomax-search-box-header').toggle();
		});
		
		$photomaxContainer.on('click','#photomax-search-box-header', function (e) {
			return false;
		});
		*/
		
		$(window).resize(function() {
			clearTimeout(layoutResizeTimer);
			layoutResizeTimer = setTimeout(function(){
				$('body').find('.photomax').each(function(){
					$pmaxContainer = $(this);
					//console.log("setting media queries");
					setMediaQueries($pmaxContainer.width(),$pmaxContainer);
				});
				
				setTimeout(function(){
					$('body').find('.photomax').each(function(){
						$(this).find('ul').masonry('layout'); 
					});
				}, photomax_global_options.updateLayoutDelay);
				
				resizePopup();
				
			}, photomax_global_options.updateLayoutDelay);
		});
		
		//Adding this as a Safety Net
		$(window).on('load', function(){
			setTimeout(function(){
				$('body').find('.photomax').each(function(){
					$(this).find('ul').masonry('layout'); 
				});
			}, photomax_global_options.updateLayoutDelay);
		});	
	
		//advertisements
		$photomaxContainer.on('mouseenter','.photomax-ad-space', function(){
		//$(".photomax-ad-space").mouseenter(function(){
			$(this).find('.photomax-advertisement-button').css('background-color',$(this).data("title-color")).css('color',$(this).data("background-color"));
		}).on('mouseleave','.photomax-ad-space',function(){
		//}).mouseleave(function(){
			$(this).find('.photomax-advertisement-button').css('color',$(this).data("title-color")).css('background-color',$(this).data("background-color"));
		});
	

		displayChannelHeader($photomaxContainer);
		displayBannerAdverisements($photomaxContainer);
	},
	
	resizePopup = function() {
		
		$photomaxPlayBox = $('.photomax-popup.mfp-gallery');
		
		//console.log('resizePopup $photomaxPlayBox : ',$photomaxPlayBox);
		//console.log('screen.width : ',screen.width);
		
		if(null==$photomaxPlayBox || $photomaxPlayBox.length == 0) {
			return;
		}
	
		if($(window).width()<1000) {
			//bottom popup
			//console.log('removing side popup');
			$photomaxPlayBox.removeClass('photomax-side-popup');
			$photomaxPlayBox.find('figcaption').css('height','auto');
			$photomaxPlayBox.addClass('photomax-bottom-popup');
		} else if($(window).width()>1000 && $photomaxPlayBox.find('img.mfp-img').width()<550 && $photomaxPlayBox.find('img.mfp-img').height()>450) {
			//side popup
			$photomaxPlayBox.addClass('photomax-side-popup');
			$photomaxPlayBox.find('figcaption').css('height',$photomaxPlayBox.find('img.mfp-img').height());
			$photomaxPlayBox.removeClass('photomax-bottom-popup');					
		}	

	},
	
	paginationWrapper = function($photomaxContainer,handle) {
		
		//console.log(handle);
		
		if(handle=="previous") {
			pauseLoadMoreButton($photomaxContainer,"previous");
		} else {
			pauseLoadMoreButton($photomaxContainer);
		}

		var tabId = $photomaxContainer.find(".photomax-tab-hover").attr("id");
		
		if(handle=="more") {
			handlePagination($photomaxContainer,handle,false,true,false,tabId);
		} else {
			$photomaxContainerList = $photomaxContainer.find('ul#tiles');
			var current_height = $photomaxContainerList.height();
			$photomaxContainerList.parent('#photomax-video-list-div').css('min-height',current_height);		
			$photomaxContainerList.find('li').addClass("photomax-dying");//.fadeTo(200, 0.3, function(){
			handlePagination($photomaxContainer,handle,false,false,true,tabId);
		}
		
		
		//setTimeout(function(){
				//handlePagination($photomaxContainer,handle);
			//}, 1000);
		//});
		
	
	},
	
	handlePagination = function($photomaxContainer,handle,createFlag,loadMoreFlag,paginateFlag,tabId) {

		//console.log('handle pagination');
		
		var instagramResponse = {
			data:[],
			pagination: {
				next_url: "photomax-generated"
			}
		};
		
		var facebookResponse = {
			data:[],
			paging: {
				next: "photomax-generated"
			}
		};
		
		var googleResponse = {
			feed:{
				entry:[]
			},
			openSearch$startIndex: {
				$t: "photomax-generated"
			}
		};
		
		
		
		//setMinimumContainerHeight($photomaxContainer);
		
		//console.log('-------------'+$photomaxContainer.attr('id')+'-------------');
		
		cache = $photomaxContainer.data('cache');
		cacheIndex = $photomaxContainer.data('cacheindex');	

		//console.log('cache length: '+cache.length);
		
		//console.log('handle pag - initia cache index:'+cacheIndex);
		//var tempCache = cache;
		var tempCacheIndex;
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		
		//console.log("inside handlePagination for - "+handle);
		
		//videoType = $(".photomax-tab-hover").attr("id").split("_")[0];
		//console.log(videoType);
		
		onScreenItems = $photomaxContainer.find('#tiles>li').length;
		
		if(handle=="previous") {
			//if(cacheIndex>=0) {
			if((cacheIndex - onScreenItems - (photomax_global_options.maxResults)) >= 0) {
				/*for(var p=cacheIndex, c=photomax_global_options.maxResults; c>0; c--,p++) {
					response.items.push()
				}*/
				cacheIndex = cacheIndex - onScreenItems - (photomax_global_options.maxResults);
				if(cacheIndex<0) cacheIndex = 0;

				//console.log("handle pagination (previous) cacheIndex: "+cacheIndex);
				//console.log("cache.length: "+cache.length);
				
				instagramResponse.data = (cache.slice(cacheIndex,cacheIndex+photomax_global_options.maxResults));
				facebookResponse.data = (cache.slice(cacheIndex,cacheIndex+photomax_global_options.maxResults));
				googleResponse.feed.entry = (cache.slice(cacheIndex,cacheIndex+photomax_global_options.maxResults));
				
				//console.log(instagramResponse);
				
				tunnelCachedResults(tabId,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag,instagramResponse,facebookResponse,googleResponse);
				
				cacheIndex = cacheIndex + photomax_global_options.maxResults;
				//console.log("cacheIndex > "+cacheIndex);
			} else {
				if(photomax_global_options.showTextInsteadOfIcons) {
					$photomaxContainer.find('#photomax-previous-div').removeClass('photomax-load-more-div-click').html('Done');
				} else {
					$photomaxContainer.find('#photomax-previous-div').removeClass('photomax-load-more-div-click').html('<i class="fa fa-close fa-5x"></i>');
				}
				$photomaxContainer.find('ul#tiles li').removeClass("photomax-dying").fadeTo(0, 1);
			}
		
		
		} else if(handle=="next" || handle=="more") {
			//console.log("handle pagination (next) cacheIndex: "+cacheIndex);
			//console.log("cache index: "+cacheIndex);
			if(cacheIndex+photomax_global_options.maxResults > cache.length) {
				//console.log("cache length > "+cache.length);
				//console.log("max results > "+photomax_global_options.maxResults);
				//console.log("handle > "+handle);

				if(handle=="next") {
					$photomaxLoadMoreDiv = $photomaxContainer.find('#photomax-next-div');				
				} else if(handle=="more") {
					$photomaxLoadMoreDiv = $photomaxContainer.find('#photomax-load-more-div');				
				}
				
				var nextPageToken = $photomaxLoadMoreDiv.data('nextpagetoken');
				//console.log(nextPageToken);
				
				if(null==nextPageToken || nextPageToken=="undefined" || nextPageToken=="") {
					//no more loads avaialbe, so just show the last photos in the cache
					if(cache.length > cacheIndex) {

						instagramResponse.data = (cache.slice(cacheIndex,cache.length));
						facebookResponse.data = (cache.slice(cacheIndex,cache.length));
						googleResponse.feed.entry = (cache.slice(cacheIndex,cache.length));
					
						tunnelCachedResults(tabId,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag,instagramResponse,facebookResponse,googleResponse);
						
						cacheIndex = cache.length;
						//deactivateLoadMoreButton($photomaxContainer);
					} else {
						deactivateLoadMoreButton($photomaxContainer);
					}
				} else {
					//console.log("calling load more playlists");
					loadMoreItems($photomaxContainer,$photomaxLoadMoreDiv);
				}
				
			} else {
				//tempCacheIndex = cacheIndex + photomax_global_options.maxResults + 1;
				//console.log("tempCacheIndex>"+tempCacheIndex);
				
				instagramResponse.data = (cache.slice(cacheIndex,cacheIndex+photomax_global_options.maxResults));
				facebookResponse.data = (cache.slice(cacheIndex,cacheIndex+photomax_global_options.maxResults));
				googleResponse.feed.entry = (cache.slice(cacheIndex,cacheIndex+photomax_global_options.maxResults));
				
				tunnelCachedResults(tabId,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag,instagramResponse,facebookResponse,googleResponse);
				
				cacheIndex = cacheIndex + photomax_global_options.maxResults;
				//console.log("cacheIndex > "+cacheIndex);
			}
			
			if(cacheIndex<0) {
				cacheIndex = 0;
			}
			
		}
		
		//console.log("handle pagination (after) cacheIndex: "+cacheIndex);
		//console.log("cache.length: "+cache.length);
		
		
		$photomaxContainer.data('cache',cache);
		$photomaxContainer.data('cacheindex',cacheIndex);				
	
	},
	
	tunnelCachedResults = function(tabId,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag,instagramResponse,facebookResponse,googleResponse) {

		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		
		//console.log('googleResponse:',googleResponse);
		
		setTimeout(function(){
			if(tabId.indexOf("instagram_user_photos_")!=-1) {
				insertInstagramPhotos(instagramResponse,null,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag);
			} else if(tabId.indexOf("instagram_user_tagged_photos_")!=-1) {
				insertInstagramPhotos(instagramResponse,null,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag);
			} else if(tabId.indexOf("instagram_global_tagged_photos_")!=-1) {
				insertInstagramPhotos(instagramResponse,null,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag);
			} else if(tabId.indexOf("facebook_album_photos_")!=-1) {
				insertFacebookPhotos(facebookResponse,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag);
			} else if(tabId.indexOf("facebook_page_photos_")!=-1) {
				insertFacebookPhotos(facebookResponse,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag);
			} else if(tabId.indexOf("facebook_page_albums_")!=-1) {
				insertFacebookAlbums(facebookResponse,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag);
			} else if(tabId.indexOf("google_album_photos_")!=-1) {
				insertGooglePhotos(googleResponse,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag);
			} else if(tabId.indexOf("google_user_photos_")!=-1) {
				insertGooglePhotos(googleResponse,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag);
			} else if(tabId.indexOf("google_user_albums_")!=-1) {
				insertGoogleAlbums(googleResponse,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag);
			}
			
		}, photomax_global_options.minimumFadeTimeout);
	
	},

	
	//load more button functionality
	loadMoreItems = function($photomaxContainer,$photomaxLoadMoreDiv) {
	
		//this will be done by handlePagination
		//$photomaxLoadMoreDiv = pauseLoadMoreButton($photomaxContainer);
		
		var tabId = $photomaxContainer.find('.photomax-tab.photomax-tab-hover').attr('id');
		var nextPageToken = $photomaxLoadMoreDiv.data('nextpagetoken');

		if(null!=nextPageToken && nextPageToken!="undefined" && nextPageToken!="") {
			
			if(tabId.indexOf("instagram_user_photos_")!=-1) {
				innerId=tabId.substring(22);
				getInstagramUserPhotos(innerId,tabId,nextPageToken,$photomaxContainer);
			} else if(tabId.indexOf("instagram_user_tagged_photos_")!=-1) {
				innerId=tabId.substring(29);
				getInstagramUserTaggedPhotos(innerId,tabId,nextPageToken,$photomaxContainer);
			} else if(tabId.indexOf("instagram_global_tagged_photos_")!=-1) {
				innerId=tabId.substring(31);
				getInstagramGlobalTaggedPhotos(innerId,tabId,nextPageToken,$photomaxContainer);
			} else if(tabId.indexOf("google_album_photos_")!=-1) {
				innerId=tabId.substring(20);
				getGoogleAlbumPhotos(innerId,tabId,nextPageToken,$photomaxContainer);
			} else if(tabId.indexOf("google_user_photos_")!=-1) {
				innerId=tabId.substring(19);
				getGoogleUserPhotos(innerId,tabId,nextPageToken,$photomaxContainer);
			}  else if(tabId.indexOf("google_user_albums_")!=-1) {
				innerId=tabId.substring(19);
				getGoogleUserAlbums(innerId,tabId,nextPageToken,$photomaxContainer);
			} else if(tabId.indexOf("facebook_album_photos_")!=-1) {
				innerId=tabId.substring(22);
				getFacebookAlbumPhotos(innerId,tabId,nextPageToken,$photomaxContainer);
			} else if(tabId.indexOf("facebook_page_photos_")!=-1) {
				innerId=tabId.substring(21);
				getFacebookPagePhotos(innerId,tabId,nextPageToken,$photomaxContainer);
			}	
			
		} else {
		
			deactivateLoadMoreButton($photomaxContainer);
			
		}
	},
	
	pauseLoadMoreButton = function ($photomaxContainer,direction) {
	
		var $photomaxLoadMoreDiv;
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		
		if(photomax_global_options.showTextInsteadOfIcons) {

			if(photomax_global_options.loadMode=="loadmore") {
				$photomaxLoadMoreDiv = $photomaxContainer.find('#photomax-load-more-div');
				$photomaxLoadMoreDiv.html('Loading..');
			} else if(photomax_global_options.loadMode.indexOf("paginate")!=-1) {
				if(direction=="previous") {
					$photomaxLoadMoreDiv = $photomaxContainer.find('#photomax-previous-div');
					$photomaxLoadMoreDiv.html('Loading..');
				} else {
					$photomaxLoadMoreDiv = $photomaxContainer.find('#photomax-next-div');
					$photomaxLoadMoreDiv.html('Loading..');
				}
			}		

		} else {
		
			if(photomax_global_options.loadMode=="loadmore") {
				$photomaxLoadMoreDiv = $photomaxContainer.find('#photomax-load-more-div');
				$photomaxLoadMoreDiv.html('<i class="fa fa-ellipsis-h fa-5x"></i>');
			} else if(photomax_global_options.loadMode.indexOf("paginate")!=-1) {
				if(direction=="previous") {
					$photomaxLoadMoreDiv = $photomaxContainer.find('#photomax-previous-div');
					$photomaxLoadMoreDiv.html('<i class="fa fa-ellipsis-h fa-5x"></i>');
				} else {
					$photomaxLoadMoreDiv = $photomaxContainer.find('#photomax-next-div');
					$photomaxLoadMoreDiv.html('<i class="fa fa-ellipsis-h fa-5x"></i>');
				}
			}
			
		}		


		$photomaxLoadMoreDiv.addClass('photomax-load-more-div-click');
		
		return $photomaxLoadMoreDiv;
	
	},
	
	deactivateLoadMoreButton = function ($photomaxContainer) {
	
		var $photomaxLoadMoreDiv;
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		
		if(photomax_global_options.showTextInsteadOfIcons) {
		
			if(photomax_global_options.loadMode=="loadmore") {
				$photomaxLoadMoreDiv = $photomaxContainer.find('#photomax-load-more-div');
				$photomaxLoadMoreDiv.html('All Done');
			} else if(photomax_global_options.loadMode.indexOf("paginate")!=-1) {
				$photomaxLoadMoreDiv = $photomaxContainer.find('#photomax-next-div');
				$photomaxLoadMoreDiv.html('Done');
				$photomaxContainer.find('ul#tiles li').removeClass("photomax-dying").fadeTo(0, 1);
			}
			
		} else {
		
			if(photomax_global_options.loadMode=="loadmore") {
				$photomaxLoadMoreDiv = $photomaxContainer.find('#photomax-load-more-div');
				$photomaxLoadMoreDiv.html('<i class="fa fa-close fa-5x"></i>');
			} else if(photomax_global_options.loadMode.indexOf("paginate")!=-1) {
				$photomaxLoadMoreDiv = $photomaxContainer.find('#photomax-next-div');
				$photomaxLoadMoreDiv.html('<i class="fa fa-close fa-5x"></i>');
				$photomaxContainer.find('ul#tiles li').removeClass("photomax-dying").fadeTo(0, 1);
			}
			
		}

		$photomaxLoadMoreDiv.removeClass('photomax-load-more-div-click');
		//$photomaxLoadMoreDiv.addClass('photomax-load-more-div-click');
	
	},
	
	
	
	//get user Id for Instagram User
	getInstagramUserIdForTabs = function (userId,tab_prefix,$photomaxContainer,isSelected,tab_suffix) {
		//console.log('inside getChannelId');
		//console.log('apiUrl-'+apiUrl);
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');

		apiUrl = "https://api.instagram.com/v1/users/search?q="+userId+"&access_token="+photomax_global_options.instagramAccessToken+"&count=100";
		
		
		$.ajax({
			url: apiUrl,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'jsonp',
			success: function(response) {
				//console.log("getInstagramUserIdForTabs response: ",response);
				
				for(var c=0;c<response.data.length;c++) {
					//console.log(response.data[c].username);
					if(response.data[c].username==userId) {
						//console.log('userId:'+userId);
						//console.log('c:'+c);
						instagramUserId = response.data[c].id;
						oldTabId = (tab_prefix+userId+tab_suffix).replace(/\./g,'\\.');;
						newTabId = tab_prefix+instagramUserId+tab_suffix;
						
						//console.log(oldTabId+"\n"+newTabId);
						
						$photomaxContainer.find("#"+oldTabId).attr("id",newTabId);
						$photomaxContainer.find('option[value="'+oldTabId+'"]').attr("value",newTabId);
						
						getInstagramUserDetails(instagramUserId,newTabId,$photomaxContainer);
						
						if(isSelected) {
							$photomaxContainer.find("#"+newTabId).click();
						}
						break;
					}
				}
				
			},
			error: function(html) { alert(html); },
			beforeSend: setHeader
		});
	},
	
	//get user Id for Google User
	getGoogleUserIdForTabs = function (userId,tab_prefix,$photomaxContainer,isSelected) {
		//console.log('inside getChannelId');
		//console.log('apiUrl-'+apiUrl);
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');

		apiUrl = "https://www.googleapis.com/plus/v1/people/"+userId+"?key="+photomax_global_options.googleApiKey;

		$.ajax({
			url: apiUrl,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'jsonp',
			success: function(response) {
				//console.log("getGoogleUserIdForTabs response: ",response);
				
				googleUserId = response.id;
				oldTabId = (tab_prefix+userId).replace(/\+/g,'\\+');
				newTabId = tab_prefix+googleUserId;
				
				//console.log(oldTabId+"\n"+newTabId);
				
				$photomaxContainer.find("#"+oldTabId).attr("id",newTabId);
				$photomaxContainer.find('option[value="'+oldTabId+'"]').attr("value",newTabId);
				
				getGoogleUserDetails(googleUserId,newTabId,$photomaxContainer);
				
				if(isSelected) {
					$photomaxContainer.find("#"+newTabId).click();
				}
			},
			error: function(html) { alert(html); },
			beforeSend: setHeader
		});
	},
	
	
	setHeader = function (xhr) {
		if(xhr && xhr.overrideMimeType) {
			xhr.overrideMimeType("application/j-son;charset=UTF-8");
		}
	},
	
	//utility function to displaye view counts
	convertViewCount = function(videoViewCount) {
		//console.log(videoViewCount);
		videoViewCount = parseInt(videoViewCount,10);
		if(videoViewCount<1000) {
			
		} else if (videoViewCount<1000000) {
			videoViewCount = Math.round(videoViewCount/1000) + "k";
			
		} else if (videoViewCount<1000000000) {
			videoViewCount = (videoViewCount/1000000).toFixed(1) + "m";
		} else {
			videoViewCount = (videoViewCount/1000000000).toFixed(1) + "b";
		}
		
		return videoViewCount;
		
	},
	
	convertViewCountForThumbnail = convertViewCount,
	
	convertLikeCommentCount = convertViewCount,
	
	convertHeaderCounts = convertViewCountWithComma,
	
	//utility function to displaye view counts
	convertViewCountWithComma = function(videoViewCount) {
		
		var videoResultCount = "";
		
		if(null==videoViewCount || videoViewCount=="0") {
			return "";
		}
		
		videoViewCount = ""+videoViewCount;
		
		//console.log("videoViewCount-"+videoViewCount);
		//console.log("videoViewCount length-"+videoViewCount.length);
		
		while(videoViewCount.length>0) {
			if(videoViewCount.length > 3) {
				videoResultCount = ","+videoViewCount.substring(videoViewCount.length-3)+videoResultCount;
				videoViewCount = videoViewCount.substring(0,videoViewCount.length-3);
			} else {
				videoResultCount = videoViewCount + videoResultCount;
				break;
			}
		}
		
		return videoResultCount;
		
	},
	
	
	
	//display channel header
	displayChannelHeader = function($photomaxContainer) {
		//console.log("displayChannelHeader");
		//console.log(response);
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		var photomax_translator_text = $photomaxContainer.data("photomax_translator_text");
		
		headerTitle = photomax_global_options.headerTitle.replace(/%20/g,' ');
		headerSubTitle = photomax_global_options.headerSubTitle.replace(/%20/g,' ');
		headerImage = photomax_global_options.headerImage;
		headerBackgroundImage = photomax_global_options.headerBackgroundImage;
		headerLink = photomax_global_options.headerLink;
		
		googlePlusLink = photomax_global_options.googlePlusLink;
		twitterLink = photomax_global_options.twitterLink;
		facebookLink = photomax_global_options.facebookLink;
		
		//console.log('channelBackgroundImage-'+channelBackgroundImage);
		
		$photomaxContainer.find('#photomax-header').css('background-image',"url("+headerBackgroundImage+")");
	
		//old header
		//$photomaxContainer.find('#photomax-header-wrapper').append('<a href="https://www.youtube.com/channel/'+channelId+'" target="_blank"><div class="photomax-channel-icon"><img src="'+channelImage+'"/></div><div class="photomax-channel-data-holder"><div class="photomax-channel-title">'+channelTitle+'</div>  <div id="photomax-header-counts"><span class="photomax-header-posts"><span class="photomax-count">'+channelVideos+'</span> videos</span><span class="photomax-header-followers"><span class="photomax-count">'+channelSubscribers+'</span> subscribers</span><span class="photomax-header-following"><span class="photomax-count">'+channelViews+'</span> views</span></div>  </div></a>');
		
		$photomaxContainer.find('#photomax-header-wrapper').append('<div class="photomax-header-data"><div class="photomax-channel-icon"><a class="photmax-header-link" href="'+headerLink+'" target="_blank"><img src="'+headerImage+'"/></a></div><div class="photomax-channel-data-holder"><div class="photomax-channel-title">'+headerTitle+'</div><div class="photomax-channel-sub-title">'+headerSubTitle+'</div> <div id="photomax-header-social-links">  </div>  </div></div>');
		
		
		$photomaxSocialLinks = $photomaxContainer.find('#photomax-header-social-links');
		if(null!=googlePlusLink && googlePlusLink!="") {
			$photomaxSocialLinks.append('<a href="'+googlePlusLink+'" target="_blank"><i class="fa fa-google-plus"></i></a>');
		}
		if(null!=twitterLink && twitterLink!="") {
			$photomaxSocialLinks.append('<a href="'+twitterLink+'" target="_blank"><i class="fa fa-twitter"></i></a>');
		}
		if(null!=facebookLink && facebookLink!="") {
			$photomaxSocialLinks.append('<a href="'+facebookLink+'" target="_blank"><i class="fa fa-facebook"></i></a>');
		}
		
	},
	

	
	getVideoTrend = function (views,likes,comments,timeInMs,hotThreshold,trendingThreshold) {
		
		if(null!=views && views!="") {
			views = parseInt(views,10);
		} else {
			views = 0;
		}
		
		if(null!=likes && likes!="") {
			likes = parseInt(likes,10);
		} else {
			likes = 0;
		}
		
		if(null!=comments && comments!="") {
			comments = parseInt(comments,10);
		} else {
			comments = 0;
		}
		
		//timeInMs = Math.abs(new Date() - new Date(time));
		//console.log(timeInMs);
		
		dateDiffDY = timeInMs/1000/60/60/24;
		
		var score = (views + 100*likes + 300*comments)/dateDiffDY;

		//console.log('views: '+views);
		//console.log('likes: '+likes);
		//console.log('comments: '+comments);
		
		//console.log(views + 100*likes + 300*comments);
		//console.log(dateDiffDY);
		//console.log('score: '+score);

		if(score>=hotThreshold) {
			return "hot";
		}
		
		if(score>=trendingThreshold) {
			return "trending";
		}
		
		return "classic";
		
	},

	
	
	processDescription = function(description) {
	
		
		
		description = description.replace(/"/g, "'");
		//console.log(description);
		
		//spotArray = description.match(/http(s)*:\/\/.+?(\s|\n|$)/g);
		spotArray = description.match(/(http(s)*:\/\/|www\.).+?(\s|\n|$)/g);
		
		//console.log(description);
		//console.log(spotArray);

		//console.log(message);
		//console.log(spotArray);
		if(null!=spotArray) {
			for(var i=0;i<spotArray.length;i++) {
				spotArray[i] = spotArray[i].trim();
				if(spotArray[i].indexOf("www.")==0) {
					replaceLink = "http://"+spotArray[i];
				} else {
					replaceLink = spotArray[i];
				}
				description = description.replace(spotArray[i],"<a target='_blank' href='"+replaceLink+"' class='famax-link'>"+spotArray[i]+"</a>");
			}
		}
	
		//spotArray = description.match(/www\..+?(\s|\n|$)/g);
		//spotArray = description.match(/(http(s)*:\/\/|www.).+?(\s|\n|$)/g);
		
		//added new
		description = description.replace(/\n/g,"<br>");
		
		/*if(null!=spotArray) {
			for(var i=0;i<spotArray.length;i++) {
				spotArray[i] = spotArray[i].trim();
				description = description.replace(spotArray[i],"<a target='_blank' href='http://"+spotArray[i]+"' class='famax-link'>"+spotArray[i]+"</a>");
			}
		}*/
	
		return description;					
	},
	
	
	
	//insert HTML for video thumbnails into photomax grid
	insertInstagramPhotos = function(response,hashTag,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag) {
		//console.log(response);
		//console.log('createFlag:'+createFlag);
		//console.log('loadMoreFlag:'+loadMoreFlag);
		//console.log('paginateFlag:'+paginateFlag);
		var $photomaxContainerList = $photomaxContainer.find('ul');
		var item = '';
		//console.log('loadMoreFlag-'+loadMoreFlag);
		
		
		var photoArray = response.data;
		//var nextPageToken = response.pagination;		
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		var photomax_translator_text = $photomaxContainer.data("photomax_translator_text");
		
		
		// Tokens will be handled by updateCache now
		// Hashtags will be handled by updateCache now
		
		

		//console.log(photoArray.length);
		
		for(var i=0; i<photoArray.length; i++) {
			
			//console.log(photoArray[i].id);
			
			//Added for Ads
			if(null!= photoArray[i].type && photoArray[i].type == "advertisement") {
				item += photoArray[i].itemHTML;
				continue;
			}

			photoId = photoArray[i].id;
			if($photomaxContainerList.find('#instagram_'+photoId).length>0) {
				continue;
			}
			
			//console.log(photoArray[i].id);
			
			photoDescription = photoArray[i].caption;			
			if(null==photoDescription || photoDescription=="") {
				photoDescription = "via Instagram";
			} else {
				photoDescription = processDescription(photoDescription.text);
			}
			
			

			//this is too low res so not needed
			//photoThumbnail = photoArray[i].images.thumbnail.url; 
			photoHD = photoArray[i].images.standard_resolution.url;
			photoLD = photoArray[i].images.low_resolution.url;

			photoUploaded = photoArray[i].created_time;			
			photoComments = photoArray[i].comments.count;
			photoLikes = photoArray[i].likes.count;
			photoLink = photoArray[i].link;
			
			videoLink = "";
			type = photoArray[i].type;
			//console.log('type:'+type);
			if(type=="video") {
				videoLink = photoArray[i].videos.standard_resolution.url;
			}
			

			item += createItem("instagram",photoId,null,photoDescription,null,photoLikes,photoComments,photoUploaded,photoLink,photoLD,photoHD,photomax_global_options,photomax_translator_text,videoLink);
			

		}

		$items = $(item);

		//hack for Instagram search
		//console.log('hack:'+$photomaxContainerList.children('.photomax-grid-item').length);
		if($photomaxContainerList.children('.photomax-grid-item').length==0) {
			loadMoreFlag = false;
			paginateFlag = false;
			createFlag = true;
		}
		
		$photomaxContainerList.append($items);
		
		createGrid($photomaxContainer,"video",createFlag,loadMoreFlag,paginateFlag,$items);
		
		
	},
	
	
	updateCache = function(network,response,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag,tabId,filter) {
	
		var nextPageToken,handle;	
		var photoArray;
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');

		//console.log('updateCache');
		//console.log('-------------'+$photomaxContainer.attr('id')+'-------------');

			
		//console.log(response);
		//console.log(filter);
		
		if(photomax_global_options.loadMode=="loadmore") {
			$photomaxLoadMoreDiv = $photomaxContainer.find('#photomax-load-more-div');
			handle = 'more';
		} else if(photomax_global_options.loadMode.indexOf("paginate")!=-1) {
			$photomaxLoadMoreDiv = $photomaxContainer.find('#photomax-next-div');
			handle = 'next';
		}		
		
		if(network=='instagram') {
			nextPageToken = response.pagination;
			photoArray = response.data;
			if(null!=nextPageToken && null!=nextPageToken.next_url) {
				nextPageToken = nextPageToken.next_url;
				$photomaxLoadMoreDiv.data('nextpagetoken',nextPageToken);
			} else {
				$photomaxLoadMoreDiv.data('nextpagetoken','');
			}
			
		} else if(network=='facebook') {
			nextPageToken = response.paging;
			photoArray = response.data;
			if(null!=nextPageToken && null!=nextPageToken.next) {
				nextPageToken = nextPageToken.next;
				$photomaxLoadMoreDiv.data('nextpagetoken',nextPageToken);
			} else {
				$photomaxLoadMoreDiv.data('nextpagetoken','');
			}
			
		} else if(network=='google') {
			photoArray = response.feed.entry;
			if(null!=photoArray&&photoArray.length>0) {
				nextStartIndex = response.feed.openSearch$startIndex.$t + response.feed.openSearch$itemsPerPage.$t;
				//nextStartIndex = response.feed.openSearch$startIndex.$t + photoArray.length;
				$photomaxLoadMoreDiv.data('nextpagetoken',nextStartIndex);
			} else {
				$photomaxLoadMoreDiv.data('nextpagetoken','');
			}
		}

	
	
		if(null!=photoArray && photoArray.length > 0) {
			cache = $photomaxContainer.data('cache');

			
			//TODO: filter should be in lowercase too for ccomparison!!
			
			if(null!=filter && filter!=""){
				filter = filter.toLowerCase().replace(/_+/g,' ');
				//console.log('filter:'+filter);
				//loop to find filtered results
				for(var i=0; i<photoArray.length; i++) {
					photoDescription = photoArray[i].caption;
					//console.log(photoDescription);					
					if(null==photoDescription) {
						photoDescription ='';
					} else {
						photoDescription = photoDescription.text.toLowerCase();
					}
					if(photoDescription.indexOf(filter)==-1 &&
						photoDescription.indexOf(filter)==-1) {
						continue;
					}
					cache.push(photoArray[i]);
				}
			} else {
				cache = cache.concat(photoArray);
			}
			
			$photomaxContainer.data('cache',cache);
			
		}

		if(!loadMoreFlag && !paginateFlag) {
			addAdvertisementsToCache($photomaxContainer);
		}
		
		handlePagination($photomaxContainer,handle,createFlag,loadMoreFlag,paginateFlag,tabId);
	
	},
	
	
	
	//insert HTML for video thumbnails into photomax grid
	insertGoogleAlbums = function(response,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag) {
		//console.log("insertGoogleAlbums");
		//console.log(response);
		var $photomaxContainerList = $photomaxContainer.find('ul');
		var item = '';
		//console.log('loadMoreFlag-'+loadMoreFlag);
		
		
		var albumArray = response.feed.entry;
		
		//var nextPageUrl = response.pagination;		
		var nextStartIndex, photoIdArray=[];
		
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		var photomax_translator_text = $photomaxContainer.data("photomax_translator_text");
		//var $photomaxLoadMoreDiv;
		
		// Tokens will be handled by updateCache now
		
		//console.log(albumArray.length);
		
		for(var i=0; i<albumArray.length; i++) {

			//Added for Ads
			if(null!= albumArray[i].type && albumArray[i].type == "advertisement") {
				item += albumArray[i].itemHTML;
				continue;
			}


			albumId = albumArray[i].gphoto$id.$t;
			userId = albumArray[i].gphoto$user.$t;
			photoCount = albumArray[i].gphoto$numphotos.$t;
			albumTitle = albumArray[i].media$group.media$title.$t;
			albumDescription = albumArray[i].media$group.media$description.$t;
			albumLink = albumArray[i].link[1].href;

			if(null!=albumDescription && albumDescription!="") {
				albumTitle += albumDescription;
			}

			if(null==albumTitle || albumTitle.trim()=="") {
				albumTitle = "via Google";
			} else {
				albumTitle = processDescription(albumTitle);
			}

			
			itemId = 'google_album_photos_'+albumId+'_'+userId;
			
			/* Exclude functionality not added
			if(pimax_global_options.excludeAlbumIdArray.indexOf(itemId)!=-1) {
				continue;
			}*/
			
			if(null==photoCount||photoCount<=0) {
				continue;
			}
			
			/*if(pimax_global_options.displaySinglePhotoAlbums==false && photoCount==1) {
				continue;
			}*/
			
			if($photomaxContainerList.find(itemId).length>0) {
				continue;
			}
			
			//console.log('Photo title-'+photoTitle);
			albumThumbnail = albumArray[i].media$group.media$thumbnail[0].url;
			
			/*if(pimax_global_options.showSquareThumbnails) {
				albumThumbnail=albumThumbnail.replace("s160-c","s50-c");
			} else {
				albumThumbnail=albumThumbnail.replace("s160-c","s50");
			}*/	

			//display captions if present
			//if(pimax_global_options.displayAlbumCaption) {
				
			//}
			
			
			albumUploaded = albumArray[i].published.$t;
			timeInMs = Math.abs(new Date() - new Date(albumUploaded));
			albumUploadedFormatted = getDateDiff(timeInMs,photomax_translator_text);

			//console.log('photoUploaded-'+photoUploaded);
			
			if(photomax_global_options.thumbnailHeight!="auto") {
				//auto
				thumbnailString = '<div class="photomax-main-thumbnail" style="background-image: url('+albumThumbnail+');height: '+photomax_global_options.thumbnailHeight+';background-position: center; background-size: cover;" ></div>';
			} else {
				//can be 200px
				thumbnailString = '<img class="photomax-main-thumbnail" src="'+albumThumbnail+'">';
			}


			item += '<li id="'+itemId+'" data-description="" data-photouploaded="" class="photomax-grid-item photomax-album photomax-hidden">'+thumbnailString+'<div class="photomax-album-photo-count-wrapper"><div class="photomax-album-photo-count-box"><span class="photomax-album-photo-count">'+photoCount+'</span><br>PHOTOS<br><div class="photomax-album-line-wrapper"><span class="photomax-album-line"></span><br><span class="photomax-album-line"></span><br><span class="photomax-album-line"></span></div></div></div><p><span class="photomax-title-desc-holder"><span class="photomax-video-list-title"></span><span class="photomax-video-list-description">'+albumTitle+'</span></span><span class="photomax-trend-link-holder photomax-album-extra"><span class="photomax-trend-holder"> <span class="photomax-video-list-date">'+albumUploadedFormatted+'</span> </span>   <a class="photomax-thumbnail-link" href="'+albumLink+'" target="_blank"><span class="photomax-link photomax-album-link"><i class="fa fa-link"></i></span></a></span></p></li>';


			




		}

		$items = $(item);			

		if($photomaxContainerList.children('.photomax-grid-item').length==0) {
			loadMoreFlag = false;
			paginateFlag = false;
			createFlag = true;
		}		
		
		$photomaxContainerList.append($items);
		
		
		createGrid($photomaxContainer,"album",createFlag,loadMoreFlag,paginateFlag,$items);
		
		
	},

	
	//insert HTML for video thumbnails into photomax grid
	insertGooglePhotos = function(response,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag) {
		//console.log(response);
		var $photomaxContainerList = $photomaxContainer.find('ul');
		var item = '';
		//console.log('loadMoreFlag-'+loadMoreFlag);
		

		if(!loadMoreFlag) {
			//$photomaxContainerList.empty();
			if($photomaxContainer.find('.photomax-tab-hover').length==0) {
				//for displaying channel/user in the playlist popups
				currentUserData = $photomaxContainer.data('photomax_current_user_data');
				$photomaxContainer.find('#photomax-showing-title').append('<div id="'+$photomaxContainer.data('photomax_current_playlist_id')+'" class="photomax-tab photomax-tab-hover photomax-showing-search-title" data-username="'+currentUserData.username+'" data-userimage="'+currentUserData.userimage+'" data-userlink="'+currentUserData.userlink+'" data-userid="'+currentUserData.userid+'"><i title="Back to Albums" id="photomax-back-to-playlists" class="fa fa-chevron-circle-left fa-lg"></i> <i class="fa fa-bars fa-lg photomax-showing-playlist-icon"></i>'+$photomaxContainer.data('photomax_current_playlist_name')+'</div>').show();
			}
		}

		
		var photoArray = response.feed.entry;
		
		//var nextPageUrl = response.pagination;		
		var nextStartIndex, photoIdArray=[];
		
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		var photomax_translator_text = $photomaxContainer.data("photomax_translator_text");
		//var $photomaxLoadMoreDiv;
		
		// Tokens will be handled by updateCache now
		
		//console.log(photoArray.length);
		
		for(var i=0; i<photoArray.length; i++) {
			
			//Added for Ads
			if(null!= photoArray[i].type && photoArray[i].type == "advertisement") {
				item += photoArray[i].itemHTML;
				continue;
			}

			photoId = photoArray[i].gphoto$id.$t;
			albumId = photoArray[i].gphoto$albumid.$t;
			if($photomaxContainerList.find('#google_'+photoId).length>0) {
				continue;
			}
			
			//test
			/*albumType = photoArray[i].gphoto$albumType;
			if(albumType=="Buzz") {
				alert(albumType);
			}*/
			
			/*
			//Skip the Buzz album photos ??
			albumType = photoArray[i].gphoto$albumType;
			if(null!=albumType) {
				albumType = albumType.$t;
				if(albumType=="Buzz") {
					continue;
				}
			}
			*/

			//for getting views later
			photoIdArray.push(albumId+"_"+photoId);
			
			photoTitle = photoArray[i].media$group.media$title.$t;
			photoDescription = photoArray[i].media$group.media$description.$t;
			if(null==photoDescription || photoDescription=="") {
				photoDescription = "via Google";
			} else {
				photoDescription = processDescription(photoDescription);
			}

			
			photoLD = photoArray[i].media$group.media$thumbnail[0].url;
			/*if(photomax_global_options.showSquareThumbnails) {
				photoLD=photoLD.replace("s72","s250-c");
			} else*/ {
				photoLD=photoLD.replace("s72","s250");
			}
			photoHD = photoArray[i].media$group.media$thumbnail[0].url.replace("s72","s800");

			photoUploaded = photoArray[i].published.$t;
			
			//photoComments = photoArray[i].comments.count;
			//photoLikes = photoArray[i].likes.count;
			photoLink = photoArray[i].link[1].href;
			
			
			//type = photoArray[i].type;
			
			

			item += createItem("google",photoId,null,photoDescription,null,null,null,photoUploaded,photoLink,photoLD,photoHD,photomax_global_options,photomax_translator_text);
			

		}

		$items = $(item);			

		if($photomaxContainerList.children('.photomax-grid-item').length==0) {
			loadMoreFlag = false;
			paginateFlag = false;
			createFlag = true;
		}		
		
		$photomaxContainerList.append($items);
		
		
		createGrid($photomaxContainer,"video",createFlag,loadMoreFlag,paginateFlag,$items);
		
		userId = response.feed.gphoto$user;
		if(null==userId) {
			userId = $photomaxContainer.find('.photomax-tab-hover').data('userid');
		} else {
			userId = userId.$t;
		}
		
		getGooglePhotoStats(photoIdArray,userId,$photomaxContainer);
		
	},

	
	//insert HTML for video thumbnails into photomax grid
	insertFacebookPhotos = function(response,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag) {
		//console.log(response);

		//only for Facebook
		if(response.error!=null) {
			if(response.error.code==190 && response.error.message.indexOf('expired')!=-1) {
				alert('Session expired. Please regenerate your token.');
			}
		}

		if(!loadMoreFlag) {
			//$photomaxContainerList.empty();
			if($photomaxContainer.find('.photomax-tab-hover').length==0) {
				//for displaying channel/user in the playlist popups
				currentUserData = $photomaxContainer.data('photomax_current_user_data');
				$photomaxContainer.find('#photomax-showing-title').append('<div id="'+$photomaxContainer.data('photomax_current_playlist_id')+'" class="photomax-tab photomax-tab-hover photomax-showing-search-title" data-username="'+currentUserData.username+'" data-userimage="'+currentUserData.userimage+'" data-userlink="'+currentUserData.userlink+'" data-userid="'+currentUserData.userid+'"><i title="Back to Albums" id="photomax-back-to-playlists" class="fa fa-chevron-circle-left fa-lg"></i> <i class="fa fa-bars fa-lg photomax-showing-playlist-icon"></i>'+$photomaxContainer.data('photomax_current_playlist_name')+'</div>').show();
			}
		}		
		
		var $photomaxContainerList = $photomaxContainer.find('ul');
		var item = '';
		//console.log('loadMoreFlag-'+loadMoreFlag);
		
		var photoArray = response.data;
		//var nextPageUrl = response.paging;		
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		var photomax_translator_text = $photomaxContainer.data("photomax_translator_text");
		var $photomaxLoadMoreDiv;
		
		// Tokens will be handled by updateCache now
		
		
		//console.log(photoArray.length);
		
		for(var i=0; i<photoArray.length; i++) {
			
			//Added for Ads
			if(null!= photoArray[i].type && photoArray[i].type == "advertisement") {
				item += photoArray[i].itemHTML;
				continue;
			}

			photoId = photoArray[i].id;
			if($photomaxContainerList.find('#facebook_'+photoId).length>0) {
				continue;
			}
			
			photoDescription = photoArray[i].name;
			if(null==photoDescription || photoDescription=="") {
				photoDescription = "via Facebook";
			} else {
				photoDescription = processDescription(photoDescription);
			}
			
			
			photoHD = extractPhotoImage(photoArray[i]);
			if(photoArray[i].images.length>2) {
				photoLD = photoArray[i].images[photoArray[i].images.length-3].source;
			} else {
				photoLD = photoHD;
			}
		
			photoUploaded = photoArray[i].created_time;		

			if(null!=photoArray[i].likes) {
				photoLikes = photoArray[i].likes.summary.total_count;
			} else {
				photoLikes = null;
			}
			
			if(null!=photoArray[i].comments) {
				photoComments = photoArray[i].comments.summary.total_count;
			} else {
				photoComments = null;
			}
			
			photoLink = photoArray[i].link;
			
			

			item += createItem("facebook",photoId,null,photoDescription,null,photoLikes,photoComments,photoUploaded,photoLink,photoLD,photoHD,photomax_global_options,photomax_translator_text);
			

		}

		$items = $(item);			
		
		if($photomaxContainerList.children('.photomax-grid-item').length==0) {
			loadMoreFlag = false;
			paginateFlag = false;
			createFlag = true;
		}		
		
		$photomaxContainerList.append($items);
		
		createGrid($photomaxContainer,"video",createFlag,loadMoreFlag,paginateFlag,$items);
		
		//getVideoStats(videoIdArray,$photomaxContainer);
		
		
	},




	//insert HTML for video thumbnails into photomax grid
	insertFacebookAlbums = function(response,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag) {
		//console.log("insert Facebook Albums");
		//console.log(response);

		//only for Facebook
		if(response.error!=null) {
			if(response.error.code==190 && response.error.message.indexOf('expired')!=-1) {
				alert('Session expired. Please regenerate your token.');
			}
		}
		
		var $photomaxContainerList = $photomaxContainer.find('ul');
		var item = '';
		var coverPhotoIdArray = [];
		//console.log('loadMoreFlag-'+loadMoreFlag);
		
		var albumArray = response.data;
		//var nextPageUrl = response.paging;		
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		var photomax_translator_text = $photomaxContainer.data("photomax_translator_text");
		var $photomaxLoadMoreDiv;
		
		// Tokens will be handled by updateCache now
		
		
		//console.log(photoArray.length);
		
		for(var i=0; i<albumArray.length; i++) {

			//Added for Ads
			if(null!= albumArray[i].type && albumArray[i].type == "advertisement") {
				item += albumArray[i].itemHTML;
				continue;
			}


			albumId = albumArray[i].id;
			albumName = albumArray[i].name;
			photoCount = albumArray[i].count;
			albumLink = albumArray[i].link;

			
			if(null==photoCount)
				continue;

			if(null==albumArray[i].cover_photo) {
				continue;
			}
			
			coverPhotoId = albumArray[i].cover_photo.id;
			
			itemId = "facebook_album_photos_"+albumId;
			albumThumbnail = "";



			albumUploaded = albumArray[i].created_time;
			timeInMs = Math.abs(new Date() - new Date(albumUploaded));
			albumUploadedFormatted = getDateDiff(timeInMs,photomax_translator_text);

			/*if(famax_global_options.onClickAction=="link") {
				linkStringStart = '<a class="famax-onclick-link" target="_blank" href="'+albumArray[i].link+'">';
				linkStringEnd = '</a>';
			} else {
				linkStringStart = '';
				linkStringEnd = '';
			}*/

				
			//item+='<li id="photos_'+albumId+'">'+linkStringStart+'<img class="mfp-image '+coverPhotoId+'" src=""><div class="famax-album-photo-count-wrapper"><div class="famax-album-photo-count-box"><span class="famax-album-photo-count">'+photoCount+'</span><br>PHOTOS<br><div class="famax-album-line-wrapper"><span class="famax-album-line"></span><br><span class="famax-album-line"></span><br><span class="famax-album-line"></span></div></div></div>'+linkStringEnd+'<p><span class="famax-video-list-title">'+albumName+'</span></p></li>';

			if(photomax_global_options.thumbnailHeight!="auto") {
				//auto
				thumbnailString = '<div class="photomax-main-thumbnail '+coverPhotoId+'" style="background-image: url('+albumThumbnail+');height: '+photomax_global_options.thumbnailHeight+';background-position: center; background-size: cover;" ></div>';
			} else {
				//can be 200px
				thumbnailString = '<img class="photomax-main-thumbnail '+coverPhotoId+'" src="'+albumThumbnail+'">';
			}

			

			item += '<li id="'+itemId+'" data-description="" data-photouploaded="" class="photomax-grid-item photomax-album photomax-hidden">'+thumbnailString+'<div class="photomax-album-photo-count-wrapper"><div class="photomax-album-photo-count-box"><span class="photomax-album-photo-count">'+photoCount+'</span><br>PHOTOS<br><div class="photomax-album-line-wrapper"><span class="photomax-album-line"></span><br><span class="photomax-album-line"></span><br><span class="photomax-album-line"></span></div></div></div><p><span class="photomax-title-desc-holder"><span class="photomax-video-list-title"></span><span class="photomax-video-list-description">'+albumName+'</span></span><span class="photomax-trend-link-holder photomax-album-extra"><span class="photomax-trend-holder"> <span class="photomax-video-list-date">'+albumUploadedFormatted+'</span> </span>   <a class="photomax-thumbnail-link" href="'+albumLink+'" target="_blank"><span class="photomax-link photomax-album-link"><i class="fa fa-link"></i></span></a></span></p></li>';


			if(null!=coverPhotoId && coverPhotoId!="") {
				coverPhotoIdArray.push(coverPhotoId);
			}


			//------------------------------------------------
			

		}

		$items = $(item);			
		
		if($photomaxContainerList.children('.photomax-grid-item').length==0) {
			loadMoreFlag = false;
			paginateFlag = false;
			createFlag = true;
		}		
		
		$photomaxContainerList.append($items);
		
		//createGrid($photomaxContainer,"video",createFlag,loadMoreFlag,paginateFlag,$items);
		
		getAlbumCoverPhotos(coverPhotoIdArray,$photomaxContainer,createFlag,loadMoreFlag,paginateFlag,$items);	

		//getVideoStats(videoIdArray,$photomaxContainer);
		
		
	},
	


	addAdvertisementsToCache = function($photomaxContainer) {

		var photomax_advertisement_text = $photomaxContainer.data('photomax_advertisement_text');
		var cache = $photomaxContainer.data('cache');

		//console.log("addAdvertisementsToCache");

		//top ad space
		if(null!=photomax_advertisement_text && null!=photomax_advertisement_text.adspace) {
			//console.log("showing ad");

			var adspace = photomax_advertisement_text.adspace;

			//console.log(photomax_advertisement_text.adspace);

			for(var a=0; a<adspace.length; a++) {
				if(adspace[a].type == "grid") {
					item = createGridAdvertisement(adspace[a],a,$photomaxContainer);

					//console.log(item);
					
					advObject = {"type":"advertisement","itemHTML":item};
					cache.splice(adspace[a].gridPosition, 0, advObject);
					//add item to cache at the specific position
				}
			}

			$photomaxContainer.data('cache',cache);
			//console.log(cache);

		}

	}

	


	createGridAdvertisement = function(advertisement,advId,$photomaxContainer) {

		//console.log("inside insertAdvertisement");
		//console.log(advertisement);

		advId = "photomax_" + advertisement.type + '_' + advId;

		var adHtml = '<li class="photomax-grid-item photomax-hidden"><div class="photomax-ad-space photomax-grid-ad" id="'+advId+'" data-title-color="'+advertisement.titleColor+'" data-background-color="'+advertisement.backgroundColor+'" style="background-color:'+advertisement.backgroundColor+'; color:'+advertisement.titleColor+';"><a class="photomax-advertisement-link" href="'+advertisement.link+'" target="_blank"><div class="photomax-advertisement-label" style="background-color:'+advertisement.labelColor+';"><i class="fa '+advertisement.icon+'"></i></div><div class="photomax-advertisement-image-wrapper" style="background-image:url('+advertisement.image+')";></div><div class="photomax-advertisement-text-wrapper"><span class="photomax-advertisement-title">'+advertisement.title+'</span><span class="photomax-advertisement-description" style="color:'+advertisement.descriptionColor+';">'+advertisement.description+'</span></span><span class="photomax-advertisement-button">'+advertisement.buttonText+'</span></div></a></div></li>';

		//console.log(adHtml);

		return adHtml;
		
	},

	insertBannerAdvertisement = function(advertisement,advId,$photomaxContainer) {

		//console.log("inside insertAdvertisement");
		//console.log(advertisement);

		advId = "photomax_" + advertisement.type + '_' + advId;

		var adHtml = '<div class="photomax-ad-space photomax-banner-ad" id="'+advId+'" data-title-color="'+advertisement.titleColor+'" data-background-color="'+advertisement.backgroundColor+'" style="background-color:'+advertisement.backgroundColor+'; color:'+advertisement.titleColor+';"><a class="photomax-advertisement-link" href="'+advertisement.link+'" target="_blank"><div class="photomax-advertisement-label" style="background-color:'+advertisement.labelColor+';"><i class="fa '+advertisement.icon+'"></i></div><div class="photomax-advertisement-image-wrapper" style="background-image:url('+advertisement.image+')";></div><div class="photomax-advertisement-text-wrapper"><span class="photomax-advertisement-title">'+advertisement.title+'</span><span class="photomax-advertisement-description" style="color:'+advertisement.descriptionColor+';">'+advertisement.description+'</span></span><span class="photomax-advertisement-button">'+advertisement.buttonText+'</span></div></a></div>';

		//console.log(adHtml);

		if(advertisement.type == "banner_top") {
			$photomaxContainer.find("#photomax-showing-title").before(adHtml);
		} else if(advertisement.type == "banner_bottom") {
			$photomaxContainer.find("#photomax-video-list-div").after(adHtml);
		}

		//console.log($photomaxContainer.find(".photomax-showing-title"));

		/*
		$('#'+advId).mouseenter(function(){
			$(this).find('.photomax-advertisement-button').css('background-color',advertisement.titleColor).css('color',advertisement.backgroundColor);
		}).mouseleave(function(){
			$(this).find('.photomax-advertisement-button').css('color',advertisement.titleColor).css('background-color',advertisement.backgroundColor);
		});

		*/

	},
	
	
	createItem = function(network,photoId,photoTitle,photoDescription,photoViewCount_raw,photoLikeCount_raw,photoCommentCount_raw,photoUploaded,photoLink,photoThumbnail,photoHD,photomax_global_options,photomax_translator_text,videoLink) {
			//network = youtube|vimeo
	
			//console.log("creating item");
			
			var item = '';
			
			//processing where counts are provided
			if(null==photoViewCount_raw) {
				photoViewCount="??";
				photoViewCount_raw = 0;
			} else {
				photoViewCount = convertViewCountForThumbnail(photoViewCount_raw);
			}
			
			if(null!=photoLikeCount_raw) {
				photoLikeCount = convertLikeCommentCount(photoLikeCount_raw);
			} else {
				photoLikeCount="??";
				photoLikeCount_raw = 0;
			}

			if(null!=photoCommentCount_raw) {
				photoCommentCount = convertLikeCommentCount(photoCommentCount_raw);
			} else {
				photoCommentCount="??";
				photoCommentCount_raw = 0;
			}
			
			if(null==photoTitle) {
				photoTitle = "";
			}
			
			if(null==photoDescription) {
				photoDescription = "";
			}
			
			if(null!=photoUploaded) {
				if(network=="instagram") {
					timeInMs = Math.abs(new Date() - new Date(photoUploaded * 1000));
				} else if(network=="google" || network=="facebook") {
					timeInMs = Math.abs(new Date() - new Date(photoUploaded));
				}
				//console.log('photoUploaded: '+photoUploaded);
				//console.log('timeInMs: '+timeInMs);
				
				photoUploadedFormatted = getDateDiff(timeInMs,photomax_translator_text);
			} else {
				photoUploadedFormatted = "";
			}			
			
			if(photomax_global_options.thumbnailHeight!="auto") {
				//auto
				thumbnailWrapperStyle = 'style="background-image: url('+photoThumbnail+');height: '+photomax_global_options.thumbnailHeight+';background-position: center; background-size: cover;"';
				thumbnailString = '';
			} else {
				//can be 200px
				thumbnailString = '<img class="photomax-main-thumbnail" src="'+photoThumbnail+'">';
				thumbnailWrapperStyle = '';
			}
			
			if(photomax_global_options.displayType=='link') {
				//popup or link
				thumbnailString = '<a class="photmax-thumbnail-link" href="'+photoLink+'" target="_blank">'+thumbnailString+'</a>';
			}

			
			if(null!=videoLink && videoLink!='') {
				//this is a instagram video
				viewIconHTML = '<i class="fa fa-play"></i>';
				itemTypeString = 'photomax-custom-video';
				popupType = 'mfp-iframe';
				hrefLink = videoLink;
				videoIndicator = '<div class="photmax-video-indicator"><i class="fa fa-play"></i></div>';
			} else {
				viewIconHTML = '<i class="fa fa-search"></i>';				
				itemTypeString = 'photomax-photo';
				popupType = 'mfp-image';	
				hrefLink = photoHD;
				videoIndicator = '';
			}
			
			//set it to view type of overlay initially
			var playOverlayString='<div class="photomax-play-overlay"><div class="photomax-play-icon-holder">'+viewIconHTML+'</div></div>';
			
			if(photomax_global_options.overlayType=='view') {
				playOverlayString = '<div class="photomax-play-overlay"><div class="photomax-play-icon-holder">'+viewIconHTML+'</div></div>';
			} else if(photomax_global_options.overlayType=='link') {
				playOverlayString = '<div class="photomax-play-overlay"><div class="photomax-play-icon-holder"><i class="fa fa-link"></i></div></div>';
			} else if(photomax_global_options.overlayType=='view-link') {
				playOverlayString = '<div class="photomax-play-overlay photmax-view-link-overlay"><div class="photomax-play-icon-holder photomax-view-link-holder"> <div class="photomax-view-link-wrapper"><div class="photomax-search-icon-holder '+popupType+'" href="'+hrefLink+'">'+viewIconHTML+'</div><a href="'+photoLink+'" target="_blank"><div class="photomax-link-icon-holder"><i class="fa fa-link"></i></div></a></div></div></div>';
			} else if(photomax_global_options.overlayType=='stat-1') {
				if(photoLikeCount_raw>0) {
					playOverlayString = '<div class="photomax-play-overlay"><div class="photomax-play-icon-holder photomax-overlay-stat"><i class="fa fa-heart"></i><span class="photmax-overlay-stat-text">'+photoLikeCount+'</span></div></div>';
				} else if(photoViewCount_raw>0) {
					playOverlayString = '<div class="photomax-play-overlay"><div class="photomax-play-icon-holder photomax-overlay-stat"><i class="fa fa-dot-circle-o"></i><span class="photmax-overlay-stat-text">'+photoViewCount+'</span></div></div>';
				}
			} else if(photomax_global_options.overlayType=='stat-2') {
				if(photoLikeCount_raw>0) {
					playOverlayString = '<div class="photomax-play-overlay"><div class="photomax-play-icon-holder photomax-overlay-stat"><span class="photmax-stat1"><i class="fa fa-heart"></i><span class="photmax-overlay-stat-text">'+photoLikeCount+'</span></span>';
					
				} else if(photoViewCount_raw>0) {
					playOverlayString = '<div class="photomax-play-overlay"><div class="photomax-play-icon-holder photomax-overlay-stat"><span class="photmax-stat1"><i class="fa fa-dot-circle-o"></i><span class="photmax-overlay-stat-text">'+photoViewCount+'</span></span>';
				}
				
				if(photoCommentCount_raw>0) {
					playOverlayString += '<span class="photmax-stat2"><i class="fa fa-comment"></i><span class="photmax-overlay-stat-text">'+photoCommentCount+'</span></span>';
				}
				
				playOverlayString += '</div></div>';
			} else if(photomax_global_options.overlayType=='desc') {
				playOverlayString = '<div class="photomax-play-overlay"><div class="photomax-play-icon-holder photomax-overlay-desc"><span class="photmax-overlay-desc-text">'+photoDescription+'</span></div></div>';
			} else if(photomax_global_options.overlayType=='stat-1-desc') {
				playOverlayString = '<div class="photomax-play-overlay"><div class="photomax-play-icon-holder photomax-overlay">';
				
				if(photoLikeCount_raw>0) {
					playOverlayString += '<div class="photomax-overlay-stat"><i class="fa fa-heart"></i><span class="photmax-overlay-stat-text">'+photoLikeCount+'</span></div>';
				} else if(photoViewCount_raw>0) {
					playOverlayString += '<div class="photomax-overlay-stat"><i class="fa fa-dot-circle-o"></i><span class="photmax-overlay-stat-text">'+photoViewCount+'</span></div>';
				}
				
				playOverlayString += '<div class="photomax-overlay-desc"><span class="photmax-overlay-desc-text">'+photoDescription+'</span></div>';
				playOverlayString += '</div></div>';
			} else if(photomax_global_options.overlayType=='stat-2-desc') {
				playOverlayString = '<div class="photomax-play-overlay"><div class="photomax-play-icon-holder photomax-overlay"><div class="photomax-overlay-stat">';
				
				if(photoLikeCount_raw>0) {
					playOverlayString += '<span class="photmax-stat1"><i class="fa fa-heart"></i><span class="photmax-overlay-stat-text">'+photoLikeCount+'</span></span>';
				} else if(photoViewCount_raw>0) {
					playOverlayString += '<div class="photomax-overlay-stat"><span class="photmax-stat1"><i class="fa fa-dot-circle-o"></i><span class="photmax-overlay-stat-text">'+photoViewCount+'</span></span>';
				}
				
				if(photoCommentCount_raw>0) {
					playOverlayString += '<span class="photmax-stat2"><i class="fa fa-comment"></i><span class="photmax-overlay-stat-text">'+photoCommentCount+'</span></span>';
				}				
				
				playOverlayString += '</div><div class="photomax-overlay-desc"><span class="photmax-overlay-desc-text">'+photoDescription+'</span></div>';
				playOverlayString += '</div></div>';
			} else if(photomax_global_options.overlayType=='date') {
				photoUploadedArray = photoUploadedFormatted.split(' ');
				if(photoUploadedArray.length==2) {
					//hack for "just now" timestamps
					photoUploadedArray[0] = photoUploadedFormatted;
					photoUploadedArray[1] = "";
					photoUploadedArray[2] = "";
				}

				playOverlayString = '<div class="photomax-play-overlay"><div class="photomax-play-icon-holder photomax-overlay-date"><i class="fa fa-clock-o"></i><span class="photmax-overlay-date-number">'+photoUploadedArray[0]+'</span><span class="photmax-overlay-date-text">'+photoUploadedArray[1]+' '+photoUploadedArray[2]+'</span></div></div>';
			} else if(photomax_global_options.overlayType=='desc-date') {
			
				playOverlayString = '<div class="photomax-play-overlay"><div class="photomax-play-icon-holder photomax-date">';

				playOverlayString += '<div class="photomax-overlay-desc"><span class="photmax-overlay-desc-text">'+photoDescription+'</span></div>';

				photoUploadedArray = photoUploadedFormatted.split(' ');
				if(photoUploadedArray.length==2) {
					//hack for "just now" timestamps
					photoUploadedArray[0] = photoUploadedFormatted;
					photoUploadedArray[1] = "";
					photoUploadedArray[2] = "";
				}

				playOverlayString += '<div class="photomax-overlay-date"><i class="fa fa-clock-o"></i><span class="photmax-overlay-date-number">'+photoUploadedArray[0]+'</span><span class="photmax-overlay-date-text">'+photoUploadedArray[1]+' '+photoUploadedArray[2]+'</span></div>';
				
				playOverlayString += '</div></div>';
			} else if(photomax_global_options.overlayType=='none') {
				playOverlayString = '';
			}
			
			
			//console.log('overlay:'+photomax_global_options.overlayType);
			
			item = '<li id="'+network+'_'+photoId+'" data-description="'+photoDescription+'" data-views="'+photoViewCount+'" data-likes="'+photoLikeCount+'" data-comments="'+photoCommentCount+'" data-photouploaded="'+photoUploaded+'" data-videolink="'+videoLink+'" class="photomax-grid-item photomax-hidden '+itemTypeString+'" ><div class="photomax-thumbnail-image-wrapper '+popupType+'" href="'+hrefLink+'" '+thumbnailWrapperStyle+' >'+thumbnailString+videoIndicator+playOverlayString+'</div><p><span class="photomax-title-desc-holder"><span class="photomax-video-list-title">'+photoTitle+'</span><span class="photomax-video-list-description">'+photoDescription+'</span></span>';
			
			
			if(photomax_global_options.skin.indexOf("list")!=-1) {
			
				
			} else if(photomax_global_options.skin.indexOf("trend")!=-1) {

				
				
				trend = getVideoTrend(photoViewCount_raw,photoLikeCount_raw,photoCommentCount_raw,timeInMs,photomax_global_options.hotThreshold,photomax_global_options.trendingThreshold);
				
				if(trend=="trending") {
					icon="fa-bolt";
				} else if (trend=="hot") {
					icon="fa-fire";
				} else {
					icon="fa-check";
				}
				
				
				
				//<div class="photomax-trend-link-holder"></div>
				item += '<span class="photomax-trend-link-holder"><span class="photomax-trend-holder photomax-'+trend+'"><i class="fa '+icon+'"></i> <span class="photomax-trend-text">'+trend+'</span></span>   <a class="photomax-thumbnail-link" href="'+photoLink+'" target="_blank"><span class="photomax-link"><i class="fa fa-link"></i></span></a></span>';

				if(photoViewCount_raw>0) {
					viewString = '<span class="photomax-video-list-views" title="views"><span class="photomax-list-thumbnail-icon"><i class="fa fa fa-dot-circle-o"></i></span> <span class="photomax-all-skin-views">' + photoViewCount+'</span> <span class="photomax-views-text">'+photomax_translator_text.views+'</span></span>';
				} else {
					viewString = '';
				}
				
				if(photoLikeCount_raw>0) {
					likeString = '<span class="photomax-video-list-likes" title="likes"> <span class="photomax-list-thumbnail-icon"><i class="fa fa fa-heart"></i></span> <span class="photomax-all-skin-likes">'+photoLikeCount+'</span> <span class="photomax-views-text">'+photomax_translator_text.likes+'</span></span>';
				} else {
					likeString='';
				}
				
				if(photoCommentCount_raw>0) {
					commentString ='<span class="photomax-video-list-comments" title="comments"> <span class="photomax-list-thumbnail-icon"><i class="fa fa fa-comment"></i></span> <span class="photomax-all-skin-comments">'+photoCommentCount+'</span> <span class="photomax-views-text">'+photomax_translator_text.comments+'</span></span>';
				} else {
					commentString='';
				}
				
				dateString ='<span class="photomax-video-list-date">'+photoUploadedFormatted+'</span>';
				
				item += '<span class="photomax-view-date-holder">'+viewString+likeString+commentString+dateString+'</span></p>';
			
			} else {
			
				
			}
			
			item += '</li>';

			return item;
	
	},
	
	
	
	
	
	convertDateFormat = function (timestamp) {
		var jsDate = new Date(timestamp);
		month = ["Jan","Feb","","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
		if(jsDate.getMinutes()<10) {
			minutes = ("0"+jsDate.getMinutes());
		} else {
			minutes = (jsDate.getMinutes());
		}
		return jsDate.getDate()+" "+month[(jsDate.getMonth()+1)]+" "+jsDate.getHours()+":"+minutes+" GMT";
	
	},

	getDateDiff = function (timeInMs,photomax_translator_text) {
	
		if(null==timeInMs||timeInMs==""||timeInMs=="undefined")
			return "?";
		//console.log(new Date(timestamp));
		
		//timeInMs = Math.abs(new Date() - new Date(timestamp));
		//console.log(dateDiffMS);
		
		dateDiffHR = timeInMs/1000/60/60;
		if(dateDiffHR>24) {
			dateDiffDY = dateDiffHR/24;
			if(dateDiffDY>30) {
				dateDiffMH = dateDiffDY/30;
				if(dateDiffMH>12) {
					dateDiffYR = dateDiffMH/12;
					dateDiffYR = Math.round(dateDiffYR);
					if(dateDiffYR<=1) {
						return dateDiffYR+" "+photomax_translator_text.year+" "+photomax_translator_text.ago;
					} else {
						return dateDiffYR+" "+photomax_translator_text.years+" "+photomax_translator_text.ago;
					}						
				} else {
					dateDiffMH = Math.round(dateDiffMH);
					if(dateDiffMH<=1) {
						return dateDiffMH+" "+photomax_translator_text.month+" "+photomax_translator_text.ago;
					} else {
						return dateDiffMH+" "+photomax_translator_text.months+" "+photomax_translator_text.ago;
					}						
				}
			} else {
				dateDiffDY = Math.round(dateDiffDY);
				if(dateDiffDY<=1) {
					return dateDiffDY+" "+photomax_translator_text.day+" "+photomax_translator_text.ago;
				} else {
					return dateDiffDY+" "+photomax_translator_text.days+" "+photomax_translator_text.ago;
				}
			}
		} else {
			dateDiffHR = Math.round(dateDiffHR);
			if(dateDiffHR<1) {
				return photomax_translator_text.now;
			}else if(dateDiffHR==1) {
				return dateDiffHR+" "+photomax_translator_text.hour+" "+photomax_translator_text.ago;
			} else {
				return dateDiffHR+" "+photomax_translator_text.hours+" "+photomax_translator_text.ago;
			}
		}		

	
	},
	
	
	
	//create grid layout using Masonry
	createGrid = function($photomaxContainer,itemType,createFlag,loadMoreFlag,paginateFlag,$items) {
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');	
		var $photomaxContainerList = $photomaxContainer.find('ul#tiles');
		
		
		
		//console.log('createGrid   paginate:'+paginateFlag+'     create:'+createFlag);
		$photomaxContainerList.imagesLoaded().always(function() {
			
			$photomaxContainer.find('.photomax-loading-div').remove();
			
			$photomaxContainerList.find("li.photomax-hidden").removeClass("photomax-hidden");
			
			//console.log("images loaded");			
			
			if(loadMoreFlag) {
				//console.log("load more grid");
				//console.log($photomaxContainerList.data('masonry'));
				//console.log($photomaxContainerList.data('masonry').items.length);
				
				//setTimeout(function(){
					$photomaxContainerList.masonry('appended',$items);
				//}, 100);
					
			} else if (paginateFlag) {
				
				//console.log("paginate grid");
				$oldItems = $photomaxContainerList.find('.photomax-dying');
				//console.log($oldItems);
				/*var result = */
				$photomaxContainerList.masonry('remove',$oldItems).masonry('layout');
				//console.log(result);
				
				//setTimeout(function(){
					$photomaxContainerList.masonry('appended',$items).masonry('layout');
				//}, 100);
				
			} else if(createFlag) {
				
				if(null!=$photomaxContainerList.data('masonry')) {
					//console.log("destroying masonry");
					$photomaxContainerList.masonry('destroy');
				}
				
				//console.log("calling masonry");
				//not sure why time delay is needed
				//setTimeout(function(){
					//console.log("creating grid");			
					$photomaxGrid = $photomaxContainerList.masonry({
						// options...
						//itemSelector: '.grid-item',
						columnWidth: '.photomax-grid-item',
						percentPosition: true
					});
				//}, 100);
				
				//console.log($photomaxContainerList.data('masonry'));
				
				//DO NOT REMOVE
				setTimeout(function(){
					//add option to do relayout for slow websites
					//also used by list layout
					//console.log("Photomax Re-Layout");
					$photomaxContainer.find('ul').masonry('layout'); 
				}, photomax_global_options.updateLayoutDelay);
				
			}
			
			
			if(itemType=="album") {

				//$photomaxContainer.find('#photomax-video-list-div .photomax-main-thumbnail').click(function(){
				$items.find('.photomax-main-thumbnail').click(function(){

					//console.log($photomaxEncloserIframe);

					//Save username, userimage and userlink from playlist tab
					$currentTab = $photomaxContainer.find('.photomax-tab-hover');

					//console.log("current tab: ",$currentTab);

					$photomaxContainer.data('photomax_current_user_data',$currentTab.data());
					
					$photomaxPlaylistThumbnail = $(this).parents("li").first();
					var photomaxPlaylistId = $photomaxPlaylistThumbnail.attr("id");

					//console.log("Showing album - "+photomaxPlaylistId);
					
					
					photomax_current_playlist_name = $photomaxPlaylistThumbnail.find('.photomax-video-list-description').text();
					$photomaxContainer.data('photomax_current_playlist_name',photomax_current_playlist_name);
					$photomaxContainer.data('photomax_current_playlist_id',photomaxPlaylistId);


					displayItems(photomaxPlaylistId,$photomaxContainer);
					

					//userImage = $tab.data('userimage');
					//userName = $tab.data('username');
					//userLink = $tab.data('userlink');
					
					
				});				
			
			} else {
				registerPopup($photomaxContainer);
			}
			
			resetLoadMoreButton($photomaxContainer);
			
			if(photomax_global_options.skin.indexOf('trend')!=-1 && ($photomaxContainer.find('#tiles li:first-child').width())<200) {
				$photomaxContainer.find('.photomax-video-list-date').hide();
			}
			
			
		});
	},
	
	resetLoadMoreButton = function($photomaxContainer) {
		
		var $photomaxLoadMoreDiv;
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		
		if(photomax_global_options.showTextInsteadOfIcons) {
		
			if(photomax_global_options.loadMode=="loadmore") {
				$photomaxLoadMoreDiv = $photomaxContainer.find('#photomax-load-more-div');
				$photomaxLoadMoreDiv.html('Load More');
			} else if(photomax_global_options.loadMode.indexOf("paginate")!=-1) {
				$photomaxLoadMoreDiv = $photomaxContainer.find('#photomax-next-div');
				$photomaxLoadMoreDiv.html('Next');
				$photomaxContainer.find('#photomax-previous-div').html('Previous');
			}
		
		} else {
		
			if(photomax_global_options.loadMode=="loadmore") {
				$photomaxLoadMoreDiv = $photomaxContainer.find('#photomax-load-more-div');
				$photomaxLoadMoreDiv.html('<i class="fa fa-plus fa-5x"></i>');
			} else if(photomax_global_options.loadMode.indexOf("paginate")!=-1) {
				$photomaxLoadMoreDiv = $photomaxContainer.find('#photomax-next-div');
				$photomaxLoadMoreDiv.html('<i class="fa fa-caret-right fa-5x"></i>');
				$photomaxContainer.find('#photomax-previous-div').html('<i class="fa fa-caret-left fa-5x"></i>');
			}
		
		}
		
		$photomaxLoadMoreDiv.removeClass('photomax-load-more-div-click');
		$photomaxContainer.find('#photomax-previous-div').removeClass('photomax-load-more-div-click');
			
	},
	
	
	//register video popup on video thumbnails
	registerPopup = function($photomaxContainer,isPlaylist) {
	
		var frame_source="";
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		var photomax_translator_text = $photomaxContainer.data('photomax_translator_text');
		var youtube_frame_source="", vimeo_frame_source="";
		
		if(photomax_global_options.displayType=="popup") {
			//display video in popup
			
			//var tabId = $photomaxContainer.find(".photomax-tab-hover").attr("id");
			//frame_source = generateFrameSource("%id%",isPlaylist,$photomaxContainer);
			
			if(photomax_global_options.showTextInsteadOfIcons) {
				photomaxExtraPopupClasses = 'photomax-text-instead-of-icons';
				photomaxShowCommentsText = 'Show Comments';
				photomaxMoreCommentsText = 'Load More Comments';				
			} else {
				photomaxExtraPopupClasses = '';
				photomaxShowCommentsText = '<i class="fa fa-comments fa-3x"></i>';
				photomaxMoreCommentsText = '<i class="fa fa-plus fa-3x"></i>';
			}	
			
			if(photomax_global_options.overlayType=='view-link') {
				delegatedElement = '.photomax-search-icon-holder';
			} else if(photomax_global_options.displayType=='link') {
				delegatedElement = '.no-popup';
			} else {
				delegatedElement = '.photomax-thumbnail-image-wrapper';
			}
			
			$photomaxContainer.find('#photomax-video-list-div').magnificPopup({
				type:'image',
				delegate:delegatedElement,
				gallery: {
					enabled:true
				},
				iframe:{
					markup: '<div class="mfp-iframe-scaler">'+
					'<div class="mfp-close"></div>'+
					'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
					'<div id="photo-detail-holder" class="iframe-detail-holder">'+
					'<div class="photomax-user-details"><a href="" target="_blank" class="photomax-user-link"><div class="photomax-user-image"><img src=""></div> <div class="photomax-user-name"></div></a></div>'+
					'<div class="photo-popup-description photo-popup-description-limited"></div>'+
					'<div class="photomax-full-description-button-wrapper"><div class="photomax-full-description-button">More..</div></div>'+
					'<div class="photo-popup-stats"><div class="media-popup-stat-1"></div><div class="media-popup-stat-2"> </div><div class="media-uploaded"></div></div>'+
					'<div type="button" class="photomax-share-video-button"><i class="fa fa-share-alt fa-2x"></i></div>'+
					'<a href="" target="_blank" class="photomax-view-on-link"><div class="photomax-view-on">View on </div></a>'+
					'</div>'+	
					'</div>'+
					'</div>',
					patterns: {

					}
				},
				image:{
					markup: '<div class="mfp-figure">'+
					'<div class="mfp-close"></div>'+
					'<figure><div class="mfp-img"></div></figure>'+
					'<figcaption><div class="mfp-bottom-bar">'+
					'<div id="photo-detail-holder">'+
					'<div class="photomax-user-details"><a href="" target="_blank" class="photomax-user-link"><div class="photomax-user-image"><img src=""></div> <div class="photomax-user-name"></div></a></div>'+
					'<div class="photo-popup-description photo-popup-description-limited"></div>'+
					'<div class="photomax-full-description-button-wrapper"><div class="photomax-full-description-button">More..</div></div>'+
					'<div class="photo-popup-stats"><div class="media-popup-stat-1"></div><div class="media-popup-stat-2"> </div><div class="media-uploaded"></div></div>'+
					'<div type="button" class="photomax-share-video-button"><i class="fa fa-share-alt fa-2x"></i></div>'+
					'<a href="" target="_blank" class="photomax-view-on-link"><div class="photomax-view-on">View on </div></a>'+
					'</div>'+	
					//'<div class="mfp-counter"></div>'+
					'</div></figcaption>'+
					'</div>'
				},
				preloader:true,
				//preload: [1,1],
				showCloseBtn: true, 
				closeBtnInside: true, 
				closeOnContentClick: false, 
				closeOnBgClick: true, 
				enableEscapeKey: true, 
				modal: false, 
				alignTop: photomax_global_options.alignPopupToTop, 
				//alignTop: false, 
				removalDelay: 100, 
				mainClass: 'mfp-fade photomax-popup '+photomaxExtraPopupClasses,
				//prependTo: $photomaxContainer.get(),
				callbacks: {
					change: function(template, values, item) {
						// Triggers each time when content of popup changes
						//console.log('open:',item);
						var $baseElement = $(this.currItem.el.context).parents("li").first();
						//console.log("$baseElement",$baseElement);
						displayPhotoData($baseElement,$photomaxContainer);
					}			
				}
			});		
			
			
		} else {

			
		}
	
	},
	
	
	
	displayPhotoData = function($baseElement,$photomaxContainer) {
		
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		var photomax_translator_text = $photomaxContainer.data("photomax_translator_text");
		
		//var tabId = $photomaxContainer.find(".photomax-tab-hover").attr("id");
		
		photo_likes = $baseElement.data("likes");
		photo_comments = $baseElement.data("comments");
		photo_views = $baseElement.data("views");
		photo_description = $baseElement.data("description");
		photo_uploaded = $baseElement.find(".photomax-video-list-date").text();

		video_id_with_type = $baseElement.attr("id");
		video_type = video_id_with_type.substring(0,video_id_with_type.indexOf("_"));
		video_id = video_id_with_type.substring(video_id_with_type.indexOf("_")+1);
		video_title = $baseElement.find(".photomax-video-list-title").text();
		channel_id = $baseElement.data("channelid");

		photoLink = $baseElement.find(".photomax-thumbnail-link").attr("href");
		
		$tab = $photomaxContainer.find('.photomax-tab-hover');
		userImage = $tab.data('userimage');
		userName = $tab.data('username');
		userLink = $tab.data('userlink');
		
		//console.log(photo_likes,photo_comments,photo_views);

		setTimeout(function(){

			if(photomax_global_options.displayType=="popup") {
				$photomaxPlayBox = $('.photomax-popup.mfp-gallery');
				//console.log($photomaxPlayBox);
			} else {
				$photomaxPlayBox = $photomaxContainer;
			}
			
			
			
			if(null!=userImage) {
				$photomaxPlayBox.find('.photomax-user-image>img').attr('src',userImage);
			}
			
			if(null!=userName) {
				$photomaxPlayBox.find('.photomax-user-name').html(userName);
			}
			
			if(null!=userLink) {
				$photomaxPlayBox.find('.photomax-user-link').attr('href',userLink);
			}
			
		
			/*if(null!=video_title) {
				$photomaxPlayBox.find('.photo-popup-title').html(video_title);
			}*/
			
			if(null!=photo_description) {
				photo_description = photo_description.replace(/\n/g,"<br>");
				$photomaxPlayBox.find('.photo-popup-description').html(photo_description);
			}

			
			//Display of Views, Likes and Comments
			if(null!=photo_views && photo_views!=0 && photo_views!="??"&&null!=photo_likes && photo_likes!=0 && photo_likes!="??"&&null!=photo_comments && photo_comments!=0 && photo_comments!="??") {
				//V & L & C
				$photomaxPlayBox.find('.media-popup-stat-1').html('<i class="fa fa-dot-circle-o"></i>'+photo_views+" <span class='popup-stat-text'>"+photomax_translator_text.views+"</span>").css('width','30%').show().attr('title',photo_views+" "+photomax_translator_text.views);
				
				$photomaxPlayBox.find('.media-popup-stat-2').html('<i class="fa fa-heart"></i>'+photo_likes+" <span class='popup-stat-text'>"+photomax_translator_text.likes+"</span>").css('width','30%').show().attr('title',photo_likes+" "+photomax_translator_text.likes);
				
				$photomaxPlayBox.find('.media-uploaded').css('width','40%');
			
			} else if(null!=photo_views && photo_views!=0 && photo_views!="??"&&null!=photo_likes && photo_likes!=0 && photo_likes!="??") {
				//V & L
				$photomaxPlayBox.find('.media-popup-stat-1').html('<i class="fa fa-dot-circle-o"></i>'+photo_views+" <span class='popup-stat-text'>"+photomax_translator_text.views+"</span>").css('width','30%').show().attr('title',photo_views+" "+photomax_translator_text.views);
				
				$photomaxPlayBox.find('.media-popup-stat-2').html('<i class="fa fa-heart"></i>'+photo_likes+" <span class='popup-stat-text'>"+photomax_translator_text.likes+"</span>").css('width','30%').show().attr('title',photo_likes+" "+photomax_translator_text.likes);
				
				$photomaxPlayBox.find('.media-uploaded').css('width','40%');
			
			} else if(null!=photo_views && photo_views!=0 && photo_views!="??"&&null!=photo_comments && photo_comments!=0 && photo_comments!="??") {
				//V & C
				$photomaxPlayBox.find('.media-popup-stat-1').html('<i class="fa fa-dot-circle-o"></i>'+photo_views+" <span class='popup-stat-text'>"+photomax_translator_text.views+"</span>").css('width','30%').show().attr('title',photo_views+" "+photomax_translator_text.views);
				
				$photomaxPlayBox.find('.media-popup-stat-2').html('<i class="fa fa-comment"></i>'+photo_comments+" <span class='popup-stat-text'>"+photomax_translator_text.comments+"</span>").css('width','30%').show().attr('title',photo_comments+" "+photomax_translator_text.comments);
				
				$photomaxPlayBox.find('.media-uploaded').css('width','40%');
			
			} else if(null!=photo_likes && photo_likes!=0 && photo_likes!="??"&&null!=photo_comments && photo_comments!=0 && photo_comments!="??") {
				//L & C
				
				$photomaxPlayBox.find('.media-popup-stat-1').html('<i class="fa fa-heart"></i>'+photo_likes+" <span class='popup-stat-text'>"+photomax_translator_text.likes+"</span>").css('width','30%').show().attr('title',photo_likes+" "+photomax_translator_text.likes);
				
				$photomaxPlayBox.find('.media-popup-stat-2').html('<i class="fa fa-comment"></i>'+photo_comments+" <span class='popup-stat-text'>"+photomax_translator_text.comments+"</span>").css('width','30%').show().attr('title',photo_comments+" "+photomax_translator_text.comments);
				
				$photomaxPlayBox.find('.media-uploaded').css('width','40%');
			
			} else if(null!=photo_views && photo_views!=0 && photo_views!="??") {
				//V
				
				$photomaxPlayBox.find('.media-popup-stat-1').html('<i class="fa fa-dot-circle-o"></i>'+photo_views+" <span class='popup-stat-text'>"+photomax_translator_text.views+"</span>").css('width','50%').show().attr('title',photo_views+" "+photomax_translator_text.views);
				
				$photomaxPlayBox.find('.media-popup-stat-2').hide();
				
				$photomaxPlayBox.find('.media-uploaded').css('width','50%');
			
			} else if(null!=photo_likes && photo_likes!=0 && photo_likes!="??") {
				//L
				
				$photomaxPlayBox.find('.media-popup-stat-1').html('<i class="fa fa-heart"></i>'+photo_likes+" <span class='popup-stat-text'>"+photomax_translator_text.likes+"</span>").css('width','50%').show().attr('title',photo_likes+" "+photomax_translator_text.likes);
				
				$photomaxPlayBox.find('.media-popup-stat-2').hide();
				
				$photomaxPlayBox.find('.media-uploaded').css('width','50%');
			
			} else if(null!=photo_comments && photo_comments!=0 && photo_comments!="??") {
				//C
				
				$photomaxPlayBox.find('.media-popup-stat-1').html('<i class="fa fa-comment"></i>'+photo_comments+" <span class='popup-stat-text'>"+photomax_translator_text.comments+"</span>").css('width','50%').show().attr('title',photo_comments+" "+photomax_translator_text.comments);
				
				$photomaxPlayBox.find('.media-popup-stat-2').hide();
				
				$photomaxPlayBox.find('.media-uploaded').css('width','50%');
			
			} else {
			
				$photomaxPlayBox.find('.media-popup-stat-1').hide();
				$photomaxPlayBox.find('.media-popup-stat-2').hide();
				
				$photomaxPlayBox.find('.media-uploaded').css('width','100%');
			}
			
			
			

			

			
			//console.log('photo-detail-holder width: '+$photomaxPlayBox.find('#photo-detail-holder').width());
			
			//console.log('photo width: '+$photomaxPlayBox.find('img.mfp-img').width());
			//console.log('photo height: '+$photomaxPlayBox.find('img.mfp-img').height());
			
			
			$photomaxPlayBox.find('figcaption').css('height','auto');
			
			if($(window).width()>1000 && $photomaxPlayBox.find('img.mfp-img').width()<550 && $photomaxPlayBox.find('img.mfp-img').height()>450) {
				//side popup
				$photomaxPlayBox.addClass('photomax-side-popup');
				$photomaxPlayBox.find('figcaption').css('height',$photomaxPlayBox.find('img.mfp-img').height());
				
				
				//console.log('mfp image height: '+$photomaxPlayBox.find('img.mfp-img').height());
				
				//removing other classes
				$photomaxPlayBox.removeClass('photomax-bottom-popup');
				
			} else {
				//bottom popup
				$photomaxPlayBox.addClass('photomax-bottom-popup');

				//removing other classes
				$photomaxPlayBox.removeClass('photomax-side-popup');
				
			}
			
			
			if($photomaxPlayBox.find('#photo-detail-holder').width()<400) {
				$photomaxPlayBox.addClass('photomax-small-popup');
			} else {
				//removing other classes
				$photomaxPlayBox.removeClass('photomax-small-popup');			
			}
			
			
			
			
			
			if(null!=photo_uploaded) {
				photo_uploaded_array = photo_uploaded.split(" ");
				if(photo_uploaded_array.length==2) {
					//hack for "just now" timestamps
					//photo_uploaded_array.push(photo_uploaded_array[1])
					//photo_uploaded_array[1] = photo_uploaded_array[0];
					//photo_uploaded_array[0] = "";
					
					photo_uploaded_array[0] = photo_uploaded;
					photo_uploaded_array[1] = "";
					photo_uploaded_array[2] = "";
				}
				$photomaxPlayBox.find('.media-uploaded').html('<i class="fa fa-clock-o"></i>'+photo_uploaded_array[0]+' <span class="popup-stat-text">'+photo_uploaded_array[1]+" "+photo_uploaded_array[2]+"</span>").attr('title',photo_uploaded);
				
				if($photomaxPlayBox.find('.media-uploaded').width()<180) {
					$photomaxPlayBox.find('.media-uploaded').html('<i class="fa fa-clock-o"></i>'+photo_uploaded_array[0]+" "+photo_uploaded_array[1].charAt(0).toUpperCase());
				}
				
			}



			//hide like & comment text for small spans
			/* Removing as small popup class will automatically hide stat text*/
			//console.log("stat 1 width: "+$photomaxPlayBox.find('.media-popup-stat-1').width());
			if($photomaxPlayBox.find('.media-popup-stat-1').width()<150) {
				$photomaxPlayBox.find('.media-popup-stat-1 .popup-stat-text').hide();
			}
			//console.log("stat 2 width: "+$photomaxPlayBox.find('.media-popup-stat-1').width());			
			if($photomaxPlayBox.find('.media-popup-stat-2').width()<150) {
				$photomaxPlayBox.find('.media-popup-stat-2 .popup-stat-text').hide();
			}



			if(photoLink.indexOf("facebook.com")!=-1) {
				$photomaxPlayBox.find('.photomax-view-on').html('View On <i class="fa fa-facebook-square"></i>');
			} else if(photoLink.indexOf("google.com")!=-1) {
				$photomaxPlayBox.find('.photomax-view-on').html('View On <i class="fa fa-google-plus-square"></i>');
			} else if(photoLink.indexOf("instagram.com")!=-1) {
				$photomaxPlayBox.find('.photomax-view-on').html('View On <i class="fa fa-instagram"></i>');
			}
			$photomaxPlayBox.find('.photomax-view-on-link').attr('href',photoLink);
			
			
			$descriptionBox = $photomaxPlayBox.find('.photo-popup-description');
			if($descriptionBox.height()<98) {
				$photomaxPlayBox.find('.photomax-full-description-button-wrapper').hide();
			} else {
				$photomaxPlayBox.find('.photomax-full-description-button-wrapper').show();
				$photomaxPlayBox.find('.photomax-full-description-button').show();
				$descriptionBox.addClass('photo-popup-description-limited');
				
				$photomaxPlayBox.find('.photomax-full-description-button').click(function(){
					$descriptionBox.removeClass('photo-popup-description-limited');
					$(this).hide();
				});
			}
			
			
			$photomaxPlayBox.find('.photomax-show-button.photomax-popup-show-button').attr('id',video_id_with_type).show();
			$photomaxPlayBox.find('.photomax-show-button.photomax-popup-show-button').data('channelid',channel_id);
			$photomaxPlayBox.find('.photomax-encloser-comment-button.photomax-more-button').data('start-index',1);
			$photomaxPlayBox.find('#photomax-encloser-comment-holder').hide();
			
			if(photomax_global_options.autoLoadComments) {
				displayComments(video_id_with_type,$photomaxContainer);
			}
			
			video_type = video_id_with_type.substring(0,video_id_with_type.indexOf("_"));
			video_id = video_id_with_type.substring(video_id_with_type.indexOf("_")+1);			
			
			
			//Share
			if(photomax_global_options.shareLink=="photo") {
				shareLink = $photomaxPlayBox.find('.photomax-view-on-link').attr('href');
			} else {
				shareLink = window.location.href;
			}
			
			config = {
				networks: {
					facebook: {
						//app_id: photomax_global_options.facebookAppId
					},
					email: {
						enabled: false
					},
					pinterest: {
						enabled: false
					}
				},
				ui: {
					flyout: 'top center',
					button_text: '<i class="fa fa-2x fa-share-alt"></i>'
				},
				url: shareLink
			};

			new Share('.photomax-share-video-button', config).open();
		
		}, 100);

	},
	
	

	
	//display loading.. text
	showLoader = function($photomaxContainer) {
		$photomaxContainer.find('#photomax-video-list-div>ul').empty();
		$photomaxContainer.find("#photomax-encloser").empty();
		//$photomaxContainer.find('#photomax-video').hide();
		$photomaxContainer.find('#photomax-encloser-video').attr('src','');
		$photomaxContainer.find('#photomax-video-list-div>ul').append('<div class="photomax-loading-div" style="text-align:center; font:14px Calibri;"><div class="spinner"></div><br><span style="opacity:0;">.</span></div>');
		$photomaxContainer.find('#photomax-showing-title').empty().hide();
	},
	
	
	
	displayItems = function(tabId,$photomaxContainer) {
		
		//console.log('displayItems');
		
		//clear cache
		cache=[];
		$photomaxContainer.data('cache',cache);
		$photomaxContainer.data('cacheindex',0);
		
		//added to display load more button when any tab is clicked in New Page mode
		$photomaxContainer.removeClass("newpage");
		
		$photomaxContainer.find("#photomax-encloser").hide();
		$photomaxContainer.find("#photomax-encloser-video").attr("src","");
		showLoader($photomaxContainer);
		
		//console.log($photomaxContainer);
		
		
		if(tabId.indexOf("instagram_user_photos_")!=-1) {
			innerId=tabId.substring(22);
			getInstagramUserPhotos(innerId,tabId,null,$photomaxContainer);
		} else if(tabId.indexOf("instagram_user_tagged_photos_")!=-1) {
			innerId=tabId.substring(29);
			getInstagramUserTaggedPhotos(innerId,tabId,null,$photomaxContainer);
		} else if(tabId.indexOf("instagram_global_tagged_photos_")!=-1) {
			innerId=tabId.substring(31);
			getInstagramGlobalTaggedPhotos(innerId,tabId,null,$photomaxContainer);
		} else if(tabId.indexOf("google_album_photos_")!=-1) {
			innerId=tabId.substring(20);
			getGoogleAlbumPhotos(innerId,tabId,null,$photomaxContainer);
		} else if(tabId.indexOf("google_user_photos_")!=-1) {
			innerId=tabId.substring(19);
			getGoogleUserPhotos(innerId,tabId,null,$photomaxContainer);
		}  else if(tabId.indexOf("google_user_albums_")!=-1) {
			innerId=tabId.substring(19);
			getGoogleUserAlbums(innerId,tabId,null,$photomaxContainer);
		} else if(tabId.indexOf("facebook_album_photos_")!=-1) {
			innerId=tabId.substring(22);
			getFacebookAlbumPhotos(innerId,tabId,null,$photomaxContainer);
		} else if(tabId.indexOf("facebook_page_photos_")!=-1) {
			innerId=tabId.substring(21);
			getFacebookPagePhotos(innerId,tabId,null,$photomaxContainer);
		} else if(tabId.indexOf("facebook_page_albums_")!=-1) {
			innerId=tabId.substring(21);
			getFacebookPageAlbums(innerId,tabId,null,$photomaxContainer);
		}	
		
		$photomaxContainer.find('.photomax-tab').removeClass('photomax-tab-hover');	
		$('#'+tabId).addClass('photomax-tab-hover');
		$photomaxContainer.find('#photomax-select').val(tabId);

	},
	


	initAdvertisements = function($photomaxContainer) {
	
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		
		//console.log("inside initAdvertisements");
		//console.log(photomax_global_options.advertisementFile);

		if(null!=photomax_global_options.advertisementFile && photomax_global_options.advertisementFile!="") {
			getAdvertisementFile($photomaxContainer);
		} else {
			/*var photomax_advertisement_text = {
				"adspace": []
			};*/
			$photomaxContainer.data("photomax_advertisement_text","");
			initTranlator($photomaxContainer);
		}
	
	},
	
	getAdvertisementFile = function($photomaxContainer) {
		
		//console.log("inside getAdvertisementFile");

		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		$.ajax({
			url: photomax_global_options.advertisementFile,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'json',
			success: function(response) { 

				$photomaxContainer.data("photomax_advertisement_text",response);
				initTranlator($photomaxContainer);
				
			},
			error: function(html) { 
				/*var photomax_advertisement_text = {
					"adspace": []
				};*/
				$photomaxContainer.data("photomax_advertisement_text","");
				initTranlator($photomaxContainer);
			},
			beforeSend: setHeader
		});			
	},
	
	displayBannerAdverisements = function($photomaxContainer) {

		var photomax_advertisement_text = $photomaxContainer.data('photomax_advertisement_text');
		
		//console.log("displayBannerAdverisements");
		//console.log(photomax_advertisement_text);

		//top ad space
		if(null!=photomax_advertisement_text && null!=photomax_advertisement_text.adspace) {
			//console.log("showing ad");

			var adspace = photomax_advertisement_text.adspace;

			for(var a=0; a<adspace.length; a++) {
				if(adspace[a].type == "banner_top" || adspace[a].type == "banner_bottom") {
					insertBannerAdvertisement(adspace[a],a,$photomaxContainer);
				}
			}

		}

	}


	initTranlator = function($photomaxContainer) {
	
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		var photomax_translator_text = {
			"search":"Search",
			"uploads":"Uploads",
			"playlists":"Playlists",
			"events":"Events",
			"views":"views",
			"likes":"likes",
			"videos":"videos",
			"subscribers":"subscribers",
			"year":"year",
			"years":"years",
			"month":"month",
			"months":"months",
			"day":"day",
			"days":"days",
			"hour":"hour",
			"hours":"hours",
			"ago":"ago",
			"now":"just now",
			"thoughts":"Share your Thoughts...",
			"comments":"comments"
		};
		
		$photomaxContainer.data("photomax_translator_text",photomax_translator_text);
		
		if(null!=photomax_global_options.translatorFile && photomax_global_options.translatorFile!="") {
			getTranslationFile($photomaxContainer);
		} else {
			initiatePlugin($photomaxContainer);
		}
	
	},
	
	getTranslationFile = function($photomaxContainer) {
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		$.ajax({
			url: photomax_global_options.translatorFile,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'json',
			success: function(response) { applyTranslation(response,$photomaxContainer);},
			error: function(html) { 
				//console.log("error in getting searchlist",html); 
				initiatePlugin($photomaxContainer);
			},
			beforeSend: setHeader
		});			
	},
	
	applyTranslation = function(response,$photomaxContainer) {
		
		//console.log(response);
		photomax_translator_text = response.translator;
		$photomaxContainer.data('photomax_translator_text',photomax_translator_text);
		
		initiatePlugin($photomaxContainer);
		

	},
	
	initiatePlugin = function($photomaxContainer) {
	
		initPhotomax($photomaxContainer);		
		createTabs($photomaxContainer);
		//initHeader($photomaxContainer);
		
		
	},
	
	createTabs = function($photomaxContainer) {
		
		//console.log("create Tabs");
		var photomax_global_options = $photomaxContainer.data('photomax_global_options');
		
		$tabContainer = $photomaxContainer.find('#photomax-tabs');
		$selectConatiner = $photomaxContainer.find('#photomax-select');
		
		//Instagram User Photos Tabs
		if(null!=photomax_global_options.instagram_user_photos) {
			for(i=0; i<photomax_global_options.instagram_user_photos.length; i++) {
			
				/* not needed as of now
				if(photomax_global_options.doNotSelectTabsByDefault) {
					photomax_global_options.instagram_user_photos[i].selected = false;
				}*/
				
				userId = scrapeInstagramUserId(photomax_global_options.instagram_user_photos[i].url,"instagram_user_photos_",$photomaxContainer,photomax_global_options.instagram_user_photos[i].selected);
				
				$tabContainer.append('<span id="instagram_user_photos_'+userId+'" class="photomax-tab" >'+photomax_global_options.instagram_user_photos[i].name.replace(/%20/g,' ')+'</span>');
				
				$selectConatiner.append('<option value="instagram_user_photos_'+userId+'" class="photomax-option-highlight" >'+photomax_global_options.instagram_user_photos[i].name.replace(/%20/g,' ')+'</option>');			
				
				
			}
		}


		//Instagram User HashTag Photos Tabs
		if(null!=photomax_global_options.instagram_user_tagged_photos) {
			for(i=0; i<photomax_global_options.instagram_user_tagged_photos.length; i++) {
			
				/* not needed as of now
				if(photomax_global_options.doNotSelectTabsByDefault) {
					photomax_global_options.instagram_user_tagged_photos[i].selected = false;
				}*/
				
				hashTag = photomax_global_options.instagram_user_tagged_photos[i].hashtag.replace(/#/g,'').replace(/\s+/g,'_');
				userId = scrapeInstagramUserId(photomax_global_options.instagram_user_tagged_photos[i].url,"instagram_user_tagged_photos_",$photomaxContainer,photomax_global_options.instagram_user_tagged_photos[i].selected,hashTag);
				tabId = 'instagram_user_tagged_photos_'+userId+'_'+hashTag;
				
				$tabContainer.append('<span id="'+tabId+'" class="photomax-tab" >'+photomax_global_options.instagram_user_tagged_photos[i].name.replace(/%20/g,' ')+'</span>');
				
				$selectConatiner.append('<option value="'+tabId+'" class="photomax-option-highlight" >'+photomax_global_options.instagram_user_tagged_photos[i].name.replace(/%20/g,' ')+'</option>');			
				
				
			}
		}
		
		//Instagram Global HashTag Photos Tabs
		if(null!=photomax_global_options.instagram_global_tagged_photos) {
			for(i=0; i<photomax_global_options.instagram_global_tagged_photos.length; i++) {
			
				/* not needed as of now
				if(photomax_global_options.doNotSelectTabsByDefault) {
					photomax_global_options.instagram_global_tagged_photos[i].selected = false;
				}*/
			
				hashTag = photomax_global_options.instagram_global_tagged_photos[i].hashtag.replace(/#/g,'');
				tabId = 'instagram_global_tagged_photos_'+hashTag;
				
				$tabContainer.append('<span id="'+tabId+'" class="photomax-tab" >'+photomax_global_options.instagram_global_tagged_photos[i].name.replace(/%20/g,' ')+'</span>');
				
				$selectConatiner.append('<option value="'+tabId+'" class="photomax-option-highlight" >'+photomax_global_options.instagram_global_tagged_photos[i].name.replace(/%20/g,' ')+'</option>');			
				
				if(photomax_global_options.instagram_global_tagged_photos[i].selected) {
					$tabContainer.find('#'+tabId).click();
				}		

				getInstagramUserDetails("25025320",tabId,$photomaxContainer);
				
			}
		}
		
		

		//Google Album Photos Tabs
		if(null!=photomax_global_options.google_album_photos) {
			for(i=0; i<photomax_global_options.google_album_photos.length; i++) {
			
				/* not needed as of now
				if(photomax_global_options.doNotSelectTabsByDefault) {
					photomax_global_options.google_album_photos[i].selected = false;
				}*/
				
				
				
				albumUserPair = scrapeGoogleAlbumId(photomax_global_options.google_album_photos[i].url);
				tabId = 'google_album_photos_' + albumUserPair;
				userId = albumUserPair.substring(albumUserPair.indexOf("_")+1);
				
				$tabContainer.append('<span id="'+tabId+'" class="photomax-tab" >'+photomax_global_options.google_album_photos[i].name.replace(/%20/g,' ')+'</span>');
				
				$selectConatiner.append('<option value="'+tabId+'" class="photomax-option-highlight" >'+photomax_global_options.google_album_photos[i].name.replace(/%20/g,' ')+'</option>');			
				
				
				if(photomax_global_options.google_album_photos[i].selected) {
					$tabContainer.find('#'+tabId).click();
				}
				
				getGoogleUserDetails(userId,tabId,$photomaxContainer);
				
			}
		}


		//Google User Photos Tabs
		if(null!=photomax_global_options.google_user_photos) {
			for(i=0; i<photomax_global_options.google_user_photos.length; i++) {
			
				/* not needed as of now
				if(photomax_global_options.doNotSelectTabsByDefault) {
					photomax_global_options.google_user_photos[i].selected = false;
				}*/
				
				
				
				userId = scrapeGoogleUserId(photomax_global_options.google_user_photos[i].url,"google_user_photos_",$photomaxContainer,photomax_global_options.google_user_photos[i].selected);
				
				tabId = 'google_user_photos_' + userId;
				
				$tabContainer.append('<span id="'+tabId+'" class="photomax-tab" >'+photomax_global_options.google_user_photos[i].name.replace(/%20/g,' ')+'</span>');
				
				$selectConatiner.append('<option value="'+tabId+'" class="photomax-option-highlight" >'+photomax_global_options.google_user_photos[i].name.replace(/%20/g,' ')+'</option>');			
				
				
				/*if(photomax_global_options.google_user_photos[i].selected) {
					$tabContainer.find('#'+tabId).click();
				}*/
				
				getGoogleUserDetails(userId,tabId,$photomaxContainer);
				
			}
		}
		
		//Google User Albums Tabs
		if(null!=photomax_global_options.google_user_albums) {
			for(i=0; i<photomax_global_options.google_user_albums.length; i++) {
			
				/* not needed as of now
				if(photomax_global_options.doNotSelectTabsByDefault) {
					photomax_global_options.google_user_albums[i].selected = false;
				}*/
				
				
				
				userId = scrapeGoogleUserId(photomax_global_options.google_user_albums[i].url,"google_user_albums_",$photomaxContainer,photomax_global_options.google_user_albums[i].selected);
				
				tabId = 'google_user_albums_' + userId;
				
				$tabContainer.append('<span id="'+tabId+'" class="photomax-tab" >'+photomax_global_options.google_user_albums[i].name.replace(/%20/g,' ')+'</span>');
				
				$selectConatiner.append('<option value="'+tabId+'" class="photomax-option-highlight" >'+photomax_global_options.google_user_albums[i].name.replace(/%20/g,' ')+'</option>');			
				
				
				/*if(photomax_global_options.google_user_albums[i].selected) {
					$tabContainer.find('#'+tabId).click();
				}*/
				
				getGoogleUserDetails(userId,tabId,$photomaxContainer);
				
			}
		}
		
		

		//Facebook Album Photos Tabs
		if(null!=photomax_global_options.facebook_album_photos) {
			for(i=0; i<photomax_global_options.facebook_album_photos.length; i++) {
			
				/* not needed as of now
				if(photomax_global_options.doNotSelectTabsByDefault) {
					photomax_global_options.facebook_album_photos[i].selected = false;
				}*/
				
				albumId = scrapeFacebookAlbumId(photomax_global_options.facebook_album_photos[i].url);
				pageId = scrapeFacebookPageIdFromAlbum(photomax_global_options.facebook_album_photos[i].url);
				tabId = 'facebook_album_photos_'+albumId;
				
				$tabContainer.append('<span id="'+tabId+'" class="photomax-tab" >'+photomax_global_options.facebook_album_photos[i].name.replace(/%20/g,' ')+'</span>');
				
				$selectConatiner.append('<option value="'+tabId+'" class="photomax-option-highlight" >'+photomax_global_options.facebook_album_photos[i].name.replace(/%20/g,' ')+'</option>');			
				
				
				if(photomax_global_options.facebook_album_photos[i].selected) {
					$tabContainer.find('#'+tabId).click();
				}
				
				getFacebookUserDetails(pageId,tabId,$photomaxContainer);
				
			}
		}
		
		

		//Facebook Page Photos Tabs
		if(null!=photomax_global_options.facebook_page_photos) {
			for(i=0; i<photomax_global_options.facebook_page_photos.length; i++) {
			
				/* not needed as of now
				if(photomax_global_options.doNotSelectTabsByDefault) {
					photomax_global_options.facebook_page_photos[i].selected = false;
				}*/
				
				pageId = scrapeFacebookPageId(photomax_global_options.facebook_page_photos[i].url);
				tabId = 'facebook_page_photos_'+pageId;
				
				$tabContainer.append('<span id="'+tabId+'" class="photomax-tab" >'+photomax_global_options.facebook_page_photos[i].name.replace(/%20/g,' ')+'</span>');
				
				$selectConatiner.append('<option value="'+tabId+'" class="photomax-option-highlight" >'+photomax_global_options.facebook_page_photos[i].name.replace(/%20/g,' ')+'</option>');			
				
				
				if(photomax_global_options.facebook_page_photos[i].selected) {
					$tabContainer.find('#'+tabId).click();
				}
				
				getFacebookUserDetails(pageId,tabId,$photomaxContainer);
				
				
			}
		}


		//Facebook Page Albums Tabs
		if(null!=photomax_global_options.facebook_page_albums) {
			for(i=0; i<photomax_global_options.facebook_page_albums.length; i++) {
			
				/* not needed as of now
				if(photomax_global_options.doNotSelectTabsByDefault) {
					photomax_global_options.facebook_page_albums[i].selected = false;
				}*/
				
				pageId = scrapeFacebookPageId(photomax_global_options.facebook_page_albums[i].url);
				tabId = 'facebook_page_albums_'+pageId;
				
				$tabContainer.append('<span id="'+tabId+'" class="photomax-tab" >'+photomax_global_options.facebook_page_albums[i].name.replace(/%20/g,' ')+'</span>');
				
				$selectConatiner.append('<option value="'+tabId+'" class="photomax-option-highlight" >'+photomax_global_options.facebook_page_albums[i].name.replace(/%20/g,' ')+'</option>');			
				
				
				if(photomax_global_options.facebook_page_albums[i].selected) {
					$tabContainer.find('#'+tabId).click();
				}
				
				getFacebookUserDetails(pageId,tabId,$photomaxContainer);
				
				
			}
		}		
		
		
		
		

		//Always Use Dropdown Setting
		if(photomax_global_options.alwaysUseDropdown) {
			$photomaxContainer.find('#photomax-select-box').css('display','block');
			$photomaxContainer.find('#photomax-tabs').hide();
		}
		
		
	
	},

	
	scrapeFacebookAlbumId = function(source_url) {
	
		albumId = "null";
		
		s=source_url.indexOf("?set=a.");
		//console.log('s-'+s);
		if(s!=-1) {
			e = source_url.indexOf(".",s+7);
			albumId = source_url.substring(s+7,e);
		} else {
			alert("Could Not Find Album.. "+source_url);
		}
		
		return albumId;
	
	},	

	scrapeFacebookPageIdFromAlbum = function(source_url) {
	
		pageId = "null";
		
		s=source_url.lastIndexOf(".");
		//console.log('s-'+s);
		if(s!=-1) {
			e = source_url.indexOf("&",s);
			pageId = source_url.substring(s+1,e);
		} else {
			alert("Could Not Find Page.. "+source_url);
		}
		
		return pageId;
	
	},	
	
	
	scrapeFacebookPageId = function(source_url) {
	
		pageId = "null";
		
		s=source_url.lastIndexOf("/");
		//console.log('s-'+s);
		if(s!=-1) {
			pageId = source_url.substring(s+1);
		} else {
			alert("Could Not Find FanPage.. "+source_url);
		}
		
		return pageId;
	
	},
	
	
	scrapeGoogleAlbumId = function(source_url) {
	
		album_user_pair = "null";
		s=source_url.indexOf("/user/");
		u=source_url.indexOf("/",s+6);
		t=source_url.indexOf("/albumid/");
		v=source_url.indexOf("?",t+9);
		//console.log('s-'+s);
		if(s!=-1) {
			userId = source_url.substring(s+6,u);
			albumId = source_url.substring(t+9,v);
			//console.log('albumId-'+albumId);
			album_user_pair = (albumId+"_"+userId);
		} else {
			alert("Could Not Find.. " + source_url);
		}
	
		return album_user_pair;
	
	},
	
	scrapeGoogleUserId = function(source_url,tab_prefix,$photomaxContainer,isSelected) {

		var userId = null;
		
		s=source_url.lastIndexOf("/");
		//console.log('s-'+s);
		if(s!=-1) {
			userId = source_url.substring(s+1);
			//userId = userId.replace(/\+/g,':');
			getGoogleUserIdForTabs(userId,tab_prefix,$photomaxContainer,isSelected);
		} else {
			alert("Could Not Find User.. "+source_url);
		}
	
		return userId;
	
	},

	
	scrapeInstagramUserId = function(source_url,tab_prefix,$photomaxContainer,isSelected,tab_suffix) {

		//console.log('scrapeInstagramUserId');
		userId = "null";
		if(null!=tab_suffix) {
			tab_suffix='_'+tab_suffix;
		} else {
			tab_suffix='';
		}
		s=source_url.lastIndexOf("/");
		//console.log('s-'+s);
		if(s!=-1) {
			userId = source_url.substring(s+1);
			getInstagramUserIdForTabs(userId,tab_prefix,$photomaxContainer,isSelected,tab_suffix);
		} else {
			alert("Could Not Find.. "+source_url);
		}
		
		return userId;
	
	},
	
	
	
	
	setMediaQueries = function(containerWidth,$photomaxContainer) {
	
		$photomaxContainer.removeClass("gt1400 gt1350 gt1300 gt1250 gt1200 gt1150 gt1100 gt1050 gt1000 gt950 gt900 lt1400 lt1350 lt1300 lt1250 lt1200 lt1150 lt1100 lt1050 lt1000 lt950 lt900 lt850 lt800 lt750 lt700 lt650 lt600 lt550 lt500 lt450 lt400");
		
		//adding media queries manually
		
		//greater than classes
		if(containerWidth>1250) {
			$photomaxContainer.addClass("gt1400");
		}

		if(containerWidth>1250) {
			$photomaxContainer.addClass("gt1350");
		}

		if(containerWidth>1250) {
			$photomaxContainer.addClass("gt1300");
		}

		if(containerWidth>1250) {
			$photomaxContainer.addClass("gt1250");
		}

		if(containerWidth>1200) {
			$photomaxContainer.addClass("gt1200");
		}

		if(containerWidth>1150) {
			$photomaxContainer.addClass("gt1150");
		}

		if(containerWidth>1100) {
			$photomaxContainer.addClass("gt1100");
		}

		if(containerWidth>1050) {
			$photomaxContainer.addClass("gt1050");
		}

		if(containerWidth>1000) {
			$photomaxContainer.addClass("gt1000");
		}
		
		if(containerWidth>950) {
			$photomaxContainer.addClass("gt950");
		}
		
		if(containerWidth>900) {
			$photomaxContainer.addClass("gt900");
		}
		
		//less than classes
		if(containerWidth<1250) {
			$photomaxContainer.addClass("lt1400");
		}		

		if(containerWidth<1250) {
			$photomaxContainer.addClass("lt1350");
		}		

		if(containerWidth<1250) {
			$photomaxContainer.addClass("lt1300");
		}		

		if(containerWidth<1250) {
			$photomaxContainer.addClass("lt1250");
		}		

		if(containerWidth<1200) {
			$photomaxContainer.addClass("lt1200");
		}		

		if(containerWidth<1150) {
			$photomaxContainer.addClass("lt1150");
		}		

		if(containerWidth<1100) {
			$photomaxContainer.addClass("lt1100");
		}		

		if(containerWidth<1050) {
			$photomaxContainer.addClass("lt1050");
		}		

		if(containerWidth<1000) {
			$photomaxContainer.addClass("lt1000");
		}		

		if(containerWidth<950) {
			$photomaxContainer.addClass("lt950");
		}		

		if(containerWidth<900) {
			$photomaxContainer.addClass("lt900");
		}

		if(containerWidth<850) {
			$photomaxContainer.addClass("lt850");
		}

		if(containerWidth<800) {
			$photomaxContainer.addClass("lt800");			
		}

		if(containerWidth<750) {
			$photomaxContainer.addClass("lt750");			
		}

		if(containerWidth<700) {
			$photomaxContainer.addClass("lt700");			
		}

		if(containerWidth<650) {
			$photomaxContainer.addClass("lt650");			
		}

		if(containerWidth<600) {
			$photomaxContainer.addClass("lt600");			
		}

		if(containerWidth<550) {
			$photomaxContainer.addClass("lt550");
		}
		
		if(containerWidth<500) {
			$photomaxContainer.addClass("lt500");
		}
		
		if(containerWidth<450) {
			$photomaxContainer.addClass("lt450");
		}	
	
		if(containerWidth<400) {
			$photomaxContainer.addClass("lt400");
		}	
	
	
	};




	//photomax plugin definition
    $.fn.photomax = function(options) {
		
		var photomax_global_options = {};
		var $photomaxContainer = this;
		//console.log($photomaxContainer.attr('id'));

		//Get CSS for Skins
		options.skin = options.skin||"trend";
		
		
		//set local options

		photomax_global_options.instagramAccessToken = options.instagramAccessToken||'260796206.0efbe26.89a76a9668934089a2d00d928486fd26';
		photomax_global_options.facebookAccessToken = options.facebookAccessToken||'CAAWvIAe5CcIBAI1XyGM8zaTjT10ZAWPXYxPFPVhuZCqSpel6VpKOo2jH6t4pr7TJ7EfZBMRfd8ztQjKjXz2q5mefzkKvCerlE2hmlhA0N7errjmpEQ7QAsrsp3aQDUR0Fn8ANDsvDZB0Hm89O7BthmfvBsorUEnJx3YOR5oiRtHDajJ9mZBrorY7q9HKjNJAZD';
		photomax_global_options.googleApiKey = options.googleApiKey||'AIzaSyDEm5wGLsWi2G3WG40re-DAJcWioQSpJ6o';
		photomax_global_options.maxResults = options.maxResults||15;
		photomax_global_options.maxResultsToLoad = options.maxResultsToLoad||30;
		
		
		photomax_global_options.alwaysUseDropdown = options.alwaysUseDropdown||false;		
		photomax_global_options.photoProtocol = options.photoProtocol||"http:";
		photomax_global_options.alignPopupToTop = options.alignPopupToTop;

		
		//photomax_global_options.searchBoxScope = options.searchBoxScope||"channel";
		//photomax_global_options.autoLoadComments = options.autoLoadComments||false;		
		//photomax_global_options.maxComments = options.maxComments||7;
		//photomax_global_options.hideComments = options.hideComments||false; 

		
		photomax_global_options.skin = options.skin;
		photomax_global_options.shareLink = options.shareLink||"photo"; //photo or website		
		photomax_global_options.viewCountType = options.viewCountType||"abbr"; //comma or abbr 
		photomax_global_options.likeCommentCountType = options.likeCommentCountType||"abbr"; //comma or abbr 
		
		photomax_global_options.loadMode = options.loadMode||"loadmore"; //loadmore or paginate-sides or paginate-bottom 
		photomax_global_options.hideHeader = options.hideHeader||false; 
		photomax_global_options.hideNavigation = options.hideNavigation||false; 
		photomax_global_options.loadButtonSize = options.loadButtonSize||"small"; //small or large
		photomax_global_options.minPhotoContainerHeight = options.minPhotoContainerHeight||10;
		photomax_global_options.hidePhotoThumbnails = options.hidePhotoThumbnails||false; 
		photomax_global_options.hideLoadMore = options.hideLoadMore||false; 
		photomax_global_options.translatorFile = options.translatorFile||"";
		photomax_global_options.advertisementFile = options.advertisementFile||"";
		photomax_global_options.hidePhotoDetails = options.hidePhotoDetails||false; 
		

		//photo sources
		photomax_global_options.instagram_user_photos = options.instagram_user_photos; 
		photomax_global_options.instagram_user_tagged_photos = options.instagram_user_tagged_photos; 
		photomax_global_options.instagram_global_tagged_photos = options.instagram_global_tagged_photos; 
		photomax_global_options.google_album_photos = options.google_album_photos; 
		photomax_global_options.google_user_photos = options.google_user_photos; 
		photomax_global_options.google_user_albums = options.google_user_albums; 
		photomax_global_options.facebook_album_photos = options.facebook_album_photos; 
		photomax_global_options.facebook_page_photos = options.facebook_page_photos; 
		photomax_global_options.facebook_page_albums = options.facebook_page_albums; 

		
		
		
		photomax_global_options.updateLayoutDelay = options.updateLayoutDelay||500; 
		photomax_global_options.hotThreshold = options.hotThreshold||150;
		photomax_global_options.trendingThreshold = options.trendingThreshold||80;
		photomax_global_options.minimumFadeTimeout = options.minimumFadeTimeout||1000; 
		//photomax_global_options.showTopAdSpace = options.showTopAdSpace||false;
		//photomax_global_options.topAdHtml = options.topAdHtml||'';
		
		photomax_global_options.fourColumnContainerWidth = options.fourColumnContainerWidth||'1150px';
		photomax_global_options.threeColumnContainerWidth = options.threeColumnContainerWidth||'1000px';
		photomax_global_options.twoColumnContainerWidth = options.twoColumnContainerWidth||'750px';
		photomax_global_options.oneColumnContainerWidth = options.oneColumnContainerWidth||'500px';		

		photomax_global_options.fiveColumnThumbnailWidth = options.fiveColumnThumbnailWidth||'18%';
		photomax_global_options.fiveColumnThumbnailLeftRightMargin = options.fiveColumnThumbnailLeftRightMargin||'1%';
		
		photomax_global_options.fourColumnThumbnailWidth = options.fourColumnThumbnailWidth||'23%';
		photomax_global_options.fourColumnThumbnailLeftRightMargin = options.fourColumnThumbnailLeftRightMargin||'1%';

		photomax_global_options.threeColumnThumbnailWidth = options.threeColumnThumbnailWidth||'30.3%';
		photomax_global_options.threeColumnThumbnailLeftRightMargin = options.threeColumnThumbnailLeftRightMargin||'1.5%';

		photomax_global_options.twoColumnThumbnailWidth = options.twoColumnThumbnailWidth||'46%';
		photomax_global_options.twoColumnThumbnailLeftRightMargin = options.twoColumnThumbnailLeftRightMargin||'2%';

		photomax_global_options.oneColumnThumbnailWidth = options.oneColumnThumbnailWidth||'95%';
		photomax_global_options.oneColumnThumbnailLeftRightMargin = options.oneColumnThumbnailLeftRightMargin||'2.5%';
		
		photomax_global_options.thumbnailBottomMargin = options.thumbnailBottomMargin||'25px';
		photomax_global_options.containerLeftRightMargin = options.containerLeftRightMargin||'2%';



		photomax_global_options.overlayType = options.overlayType||'view'; //view|link|view-link|stat-1|stat-2|desc|stat-1-desc|stat-2-desc|date|desc-date
		photomax_global_options.displayType = options.displayType||'popup'; //popup|link 
		

		photomax_global_options.showTextInsteadOfIcons = options.showTextInsteadOfIcons||false;
		//photomax_global_options.headerCountType = options.headerCountType||"abbr"; //comma or abbr 
		

		photomax_global_options.thumbnailHeight = options.thumbnailHeight||"auto";
		photomax_global_options.thumbnailDescription = options.thumbnailDescription||"fixed-3";
		//fixed-1 | fixed-2 | fixed-3 | max-1 | max-2 | max-3
		photomax_global_options.packedThumbnails = options.packedThumbnails||false;
		
		//header
		photomax_global_options.headerTitle = options.headerTitle||"Envato Pictures";
		photomax_global_options.headerSubTitle = options.headerSubTitle||"powered by PhotoMax";
		photomax_global_options.headerImage = options.headerImage||"https://yt3.ggpht.com/-FqG6biYgK3Q/AAAAAAAAAAI/AAAAAAAAAAA/v9oefAdz-4Y/s100-c-k-no/photo.jpg";
		photomax_global_options.headerBackgroundImage = options.headerBackgroundImage||"https://yt3.ggpht.com/-f6BSwYMnD04/U6ozNE2mUiI/AAAAAAAAAXU/maYUcQFqcOE/w1060-fcrop64=1,00005a57ffffa5a8-nd/yt2.jpg";
		photomax_global_options.headerLink = options.headerLink||"http://codecanyon.net/item/youmax-youtube-channel-on-your-website/9989505";
		
		photomax_global_options.googlePlusLink = options.googlePlusLink||"http://plus.google.com";
		photomax_global_options.twitterLink = options.twitterLink||"http://twitter.com";
		photomax_global_options.facebookLink = options.facebookLink||"http://facebook.com";


		
		//set global options
		$photomaxContainer.data('photomax_global_options',photomax_global_options);

		
		//process dependencies
		if(photomax_global_options.thumbnailDescription == "fixed-3") {
			$photomaxContainer.addClass("fixed-3-line-description");
		} else if(photomax_global_options.thumbnailDescription == "fixed-2") {
			$photomaxContainer.addClass("fixed-2-line-description");
		} else if(photomax_global_options.thumbnailDescription == "fixed-1") {
			$photomaxContainer.addClass("fixed-1-line-description");
		} else if(photomax_global_options.thumbnailDescription == "max-3") {
			$photomaxContainer.addClass("maximum-3-line-description");
		} else if(photomax_global_options.thumbnailDescription == "max-2") {
			$photomaxContainer.addClass("maximum-2-line-description");
		} else if(photomax_global_options.thumbnailDescription == "max-1") {
			$photomaxContainer.addClass("maximum-1-line-description");
		}
		
		if(photomax_global_options.skin=="trend1") {
			$photomaxContainer.addClass("trend1");
		} else if(photomax_global_options.skin=="trend2") {
			$photomaxContainer.addClass("trend2");
		} else if(photomax_global_options.skin=="trend3") {
			$photomaxContainer.addClass("trend3");
		} else if(photomax_global_options.skin=="trend4") {
			$photomaxContainer.addClass("trend4");
		}

		
		if(photomax_global_options.packedThumbnails) {
			photomax_global_options.threeColumnThumbnailWidth = '33.34%';
			photomax_global_options.threeColumnThumbnailLeftRightMargin = '0%';
			
			photomax_global_options.thumbnailBottomMargin = '0px';
			
		}

		if(photomax_global_options.viewCountType == "comma") {
			convertViewCountForThumbnail = convertViewCountWithComma;	
		} else {
			convertViewCountForThumbnail = convertViewCount;
		}

		if(photomax_global_options.likeCommentCountType == "comma") {
			convertLikeCommentCount = convertViewCountWithComma;	
		} else {
			convertLikeCommentCount = convertViewCount;
		}
		
		/*if(photomax_global_options.headerCountType == "comma") {
			convertHeaderCounts = convertViewCountWithComma;	
		} else {
			convertHeaderCounts = convertViewCount;
		}*/
		
		
		if(photomax_global_options.loadMode=="paginate-sides") {
			photomax_global_options.loadButtonSize="small";
		}
		
		if(null==photomax_global_options.alignPopupToTop || photomax_global_options.alignPopupToTop==="") {
			photomax_global_options.alignPopupToTop = true;
		}
		
		/*if(photomax_global_options.skin.indexOf("list")!=-1) {
			photomax_global_options.fourColumnContainerWidth = '5000px';
			photomax_global_options.threeColumnContainerWidth = '5000px';
			photomax_global_options.twoColumnContainerWidth = '5000px';
			photomax_global_options.oneColumnContainerWidth = '1400px';
			
			photomax_global_options.oneColumnThumbnailWidth = '97%';
			photomax_global_options.oneColumnThumbnailLeftRightMargin = '1.5%';
		}*/
		
		
		
		//set local cache for pagination and events
		var cache = [];
		var cacheIndex = 0;
		
		$photomaxContainer.data('cache',cache);
		$photomaxContainer.data('cacheindex',cacheIndex);

		
		//add fontawesome icons
		if (document.createStyleSheet){
			document.createStyleSheet(photomax_global_options.photoProtocol+"//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css");
		} else {
			$("head").append("<link rel='stylesheet' href='"+photomax_global_options.photoProtocol+"//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css' type='text/css' />");
		}
		
		options.maxContainerWidth = options.maxContainerWidth||1080;
		$photomaxContainer.css('max-width',(options.maxContainerWidth)+'px');
		
		var custom_styles = "";
		var photomaxElementId = '#'+$photomaxContainer.attr('id');
		//console.log('photomaxElementId:'+photomaxElementId);
		
		//Adding styles for Text instead of Icon mode
		if(photomax_global_options.showTextInsteadOfIcons) {
			$photomaxContainer.addClass("photomax-text-instead-of-icons");
		}		
		
		//adding styles for hide header
		if(photomax_global_options.hideHeader) {
			custom_styles += '#photomax-header{display:none !important;} .photomax-select-box-wrapper {padding-top: 3px;}';
		}
		
		//adding styles for hide navigation
		if(photomax_global_options.hideNavigation) {
			custom_styles += '#photomax-tabs,.photomax-select-box-wrapper,#photomax-select-box{display:none !important;}';
		}
		
		/*adding styles for hide comments
		if(photomax_global_options.hideComments) {
			custom_styles += '#photomax-encloser-comment-holder,.photomax-show-button-wrapper{display:none !important;} .photo-popup-stats {border-bottom: none !important;}';
		}*/
		
		//adding styles for hide photo details
		if(photomax_global_options.hidePhotoDetails) {
			custom_styles += '.photomax-popup figcaption{display:none !important;}';
		}
		
		/*hide complete photo detail holder
		if(photomax_global_options.hidePhotoDetails && photomax_global_options.hideComments) {
			custom_styles += '#photo-detail-holder{display:none !important;}';
		}*/
		
		//adding styles for hide video thumbnails
		if(photomax_global_options.hidePhotoThumbnails) {
			custom_styles += '#photomax-video-list-div{display:none !important;}';
		}
		
		//adding styles for hide load more and pagination
		if(photomax_global_options.hideLoadMore) {
			custom_styles += '#photomax-load-more-div,.photomax-pagination,.photomax-pagination-button-wrapper{display:none !important;}';
		}
		
		if(photomax_global_options.minPhotoContainerHeight>0) {
			custom_styles += '#photomax-video-list-div{min-height:'+photomax_global_options.minPhotoContainerHeight+'px;}';
		}
		

		
		//setting width qantifiers
		setMediaQueries($photomaxContainer.width(),$photomaxContainer);
		
		
		//adding media queries based on column thresholds
		custom_styles += photomaxElementId+' .photomax-grid-item {margin-bottom: '+photomax_global_options.thumbnailBottomMargin+';} '+photomaxElementId+' #photomax-video-list-div {padding-left: '+photomax_global_options.containerLeftRightMargin+';padding-right: '+photomax_global_options.containerLeftRightMargin+';}';
		
		photomax_global_options.fourColumnContainerWidth = photomax_global_options.fourColumnContainerWidth.replace('px','');
		custom_styles += photomaxElementId+'.gt'+photomax_global_options.fourColumnContainerWidth+' .photomax-grid-item {width: '+photomax_global_options.fiveColumnThumbnailWidth+'; margin-left: '+photomax_global_options.fiveColumnThumbnailLeftRightMargin+'; margin-right: '+photomax_global_options.fiveColumnThumbnailLeftRightMargin+';} '+photomaxElementId+'.lt'+photomax_global_options.fourColumnContainerWidth+' .photomax-grid-item {width: '+photomax_global_options.fourColumnThumbnailWidth+'; margin-left: '+photomax_global_options.fourColumnThumbnailLeftRightMargin+';margin-right: '+photomax_global_options.fourColumnThumbnailLeftRightMargin+';}';
		
		photomax_global_options.threeColumnContainerWidth = photomax_global_options.threeColumnContainerWidth.replace('px','');
		custom_styles += photomaxElementId+'.lt'+photomax_global_options.threeColumnContainerWidth+' .photomax-grid-item {width: '+photomax_global_options.threeColumnThumbnailWidth+'; margin-left: '+photomax_global_options.threeColumnThumbnailLeftRightMargin+';margin-right: '+photomax_global_options.threeColumnThumbnailLeftRightMargin+';}';
		
		photomax_global_options.twoColumnContainerWidth = photomax_global_options.twoColumnContainerWidth.replace('px','');
		custom_styles += photomaxElementId+'.lt'+photomax_global_options.twoColumnContainerWidth+' .photomax-grid-item {width: '+photomax_global_options.twoColumnThumbnailWidth+'; margin-left: '+photomax_global_options.twoColumnThumbnailLeftRightMargin+';margin-right: '+photomax_global_options.twoColumnThumbnailLeftRightMargin+';}';
		
		photomax_global_options.oneColumnContainerWidth = photomax_global_options.oneColumnContainerWidth.replace('px','');
		custom_styles += photomaxElementId+'.lt'+photomax_global_options.oneColumnContainerWidth+' .photomax-grid-item {width: '+photomax_global_options.oneColumnThumbnailWidth+'; margin-left: '+photomax_global_options.oneColumnThumbnailLeftRightMargin+';margin-right: '+photomax_global_options.oneColumnThumbnailLeftRightMargin+';}';



		$("head").append("<style class='photomax-added-styles'>"+custom_styles+"</style>");
		
		initAdvertisements($photomaxContainer);
		//initTranlator($photomaxContainer);

		//IE 10 mode
		var doc = document.documentElement;
		doc.setAttribute('data-useragent', navigator.userAgent);

		
		//return this for chaining
		return this;
 
    };
	
 
}( jQuery ));


