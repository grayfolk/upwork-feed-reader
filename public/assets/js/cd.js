function countdown() {
	let currentTime = new Date().getTime();

	let timers = document.getElementsByClassName('jsPostedInfo')
	
	if(timers.length){
		for(let i = 0; i < timers.length; i++){
			if(!timers.item(i).dataset.countdown){
				timers.item(i).dataset.countdown = 1;
				let s = currentTime - new Date(timers.item(i).dataset.posted*1000).getTime()			
				runInterval(s/1000, timers.item(i), 1000)
			}
		}
	}
	
	function runInterval(seconds, wrapper, interval){
		let timer = setInterval(function(){
//			if(seconds > 60 && wrapper.dataset.countdown == 1){
//				stopInterval(timer)
//				wrapper.dataset.countdown = 60
//				runInterval(seconds, wrapper, 1000*60)
//			}
			if(wrapper.dataset.format == 'small')
				wrapper.textContent = formatText(seconds, 'small')
			else
				wrapper.textContent = 'posted ' + formatText(seconds) + ' ago'
			seconds++
		}, interval)
	}
	
	function formatText(seconds, format){
		if(seconds < 60){
			return Math.floor(seconds) + (format == 'small' ? 'sec' : ' second(s)')
		} else if(seconds < 60*60){
			return Math.floor(seconds/60) + (format == 'small' ? 'min' : ' minute(s)')
		} else if(seconds < 60*60*24){
			return Math.floor(seconds/(60*60)) + (format == 'small' ? 'hr' : ' hour(s)')
		} else if(seconds < 60*60*24*7){
			return Math.floor(seconds/(60*60*24)) + (format == 'small' ? 'd' : ' day(s)')
		} else if(seconds < 60*60*24*30){
			return Math.floor(seconds/(60*60*24*7)) + (format == 'small' ? 'w' : ' week(s)')
		} else if(seconds < 60*60*24*365){
			return Math.floor(seconds/(60*60*24*30)) + (format == 'small' ? 'm' : ' month(s)')
		} else {
			return Math.floor(seconds/(60*60*24*365)) + (format == 'small' ? 'y' : ' year(s)')
		}
	}
}
