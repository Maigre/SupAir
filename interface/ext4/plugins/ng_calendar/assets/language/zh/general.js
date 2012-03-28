/*
 * NoGray JavaScript Library v1.0
 * http://www.NoGray.com
 *
 * Copyright (c) 2009 Wesam Saif
 * http://www.nogray.com/license.php
 */
ng.Language.set_language('zh', {
	direction: 'ltr',
	
	numbers: ["零", "一", "二", "三", "四", "五", "六", "七", "八", "九"],
	
	date: {
		date_format: 'm/d/Y',
		time_format: 'h:i a',
		
		days:{
			'char':['周日','周一','周二','周三','周四','周五','周六'],
			short:['周日','周一','周二','周三','周四','周五','周六'],
			mid:['周日','周一','周二','周三','周四','周五','周六'],
			'long':['星期日','星期一','星期二','星期三','星期四','星期五','星期六']
		},
		months:{
			short:['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
			'long':['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月']
		},
		am_pm:{
			lowercase:['上午','下午'],
			uppercase:['上午','下午']
		}	
	},
	
	yes: '是的',
	no: '无',
	
	'open': '打开',
	'close': '关闭',
	clear: '清除'
});

ng.Language.zh_translate_numbers = function(b){var a=ng.Language.get_language("zh").numbers;b=b+"";b=b.replace(/\d+/g,function(d){return c(d);function c(j){var h="";var l,n;j=j+"";if(e(j)){return j.replace(/\d/g,a[0])}var g=["","十","百","千","万","亿"];var f=j.length;var m=false;if(f>8){h+=c(j.substr(0,f-8))+g[5];j=j.substr(f-8);f=j.length;m=true}if(e(j)){return h}if(f>5){h+=c(j.substr(0,f-5)+"0");j=j.substr(f-5);f=j.length;m=true}for(var k=f;k>0;k--){l=j.substr(0,1);n=j.substr(1);if(l=="0"){if(n.substr(0,1)!="0"){h+=a[0]}if(m){h+=g[k-1]}m=false}else{if(l==1){if(n.length!=1){h+=a[l]}}else{if(l!="1"){h+=a[l]}}h+=g[k-1]}if(e(n)){return h}j=n}return h}function e(g){for(var f=0;f<g.length;f++){if(g.charAt(f)!="0"){return false}}return true}});return b};
