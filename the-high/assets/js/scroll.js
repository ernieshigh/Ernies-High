		const html = document.documentElement; 
		const canvas = document.getElementById("high-scroll");
		const context = canvas.getContext("2d");
		const main =  document.querySelector("main");
		const elem = document.querySelector(".afterScroll");
		const mainHeight = main.offsetHeight;
		
		canvas.setAttribute("width", window.innerWidth); 
		canvas.width=1158;
		canvas.height=650;
		
		const frameCount = 114;
		const currentFrame = index => (
		  `https://ernieshigh.dev/wp-content/themes/the-high/assets/images/scroll/${index.toString().padStart(4, "0")}.jpg`
		)
		 
		
		// optimize loading by preloading images
		const imagesScroll = [];
        const preloadImages = () => {
            for (let i = 1; i < frameCount; i++) {
                imagesScroll[i] = new Image();  
                imagesScroll[i].src = currentFrame(i);
            }
        }; 
		
		// Draw the first image
		const img = new Image()
		img.src = currentFrame(1);  
        img.onload = function(){
            context.drawImage(img, 0, 0);
        }
		
		const updateImage = index => {
		  img.src = currentFrame(index);
		  context.drawImage(img, 0, 0);
		}
        // Scroll interactions 
        
        window.addEventListener("scroll", () => {  
            const scrollTop = html.scrollTop; 
            const maxScrollTop = html.scrollHeight - window.innerHeight;
            const scrollFraction = scrollTop / maxScrollTop;
            const frameIndex = Math.min(
                frameCount - 1,
                Math.floor(scrollFraction * frameCount)
            ); 
			
			 elem.style.height = mainHeight + 'px'; 
		
            requestAnimationFrame(() => updateImage(frameIndex + 1))
			console.log(scrollTop)
   
		   if(scrollTop >= 770){
			  elem.classList.add("inView");
			 canvas.style.display = 'none'; 
		  } else{
			  elem.classList.remove("inView");
			  
			 
			 canvas.style.display = 'block'; 
		  } 



        });   preloadImages();