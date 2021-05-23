/*
	Laravel doesn't play well with existing datepickers, and the ones that do work don't work well with IE
	So, this is a simple, no-frills datepicker for use with MBC Laravel projects
*/

function mms_zpad(n){
	n=n*1;
	if (n<10){
		return('0' + n);
	} else {
		return('' + n);
	}
}
function mms_datepicker_clean_input(dp){
	var d=$(dp).val();
	var td=new Date();
	var dflt=(td.getMonth()+1) + '/' + td.getDate() + '/' + td.getFullYear();
	if (d!=''){
		d=d.split('-').join('/');
		var b=d.split('/');
		if (b.length==3){
            if (b[0].length>2){
    			d=mms_zpad(b[1]) + '/' + mms_zpad(b[2]) + '/' + mms_zpad(b[0]);
            } else {
    			d=mms_zpad(b[0]) + '/' + mms_zpad(b[1]) + '/' + mms_zpad(b[2]);
            }
		} else {
			d=dflt;
		}
	} else {
		if ($(dp).hasClass('required')){
			d=dflt;
		} else {
			d='';
		}
	}
console.log(d);
	$(dp).val(d);
}

function mms_datepicker_cancel(dp){
	//$(dp).parent().find('.mbcdp_stage').hide();
}
function mms_datepicker_launch(dp){
	$('.datepicker').parent().find('.mbcdp_stage').hide();
	mms_datepicker_clean_input(dp);
	var td=new Date();
	var dflt=(td.getMonth()+1) + '/' + td.getDate() + '/' + td.getFullYear();
	var d=$(dp).val();
	if (d==''){
		d=dflt;
	}
	var c=d.split('/');
	var val=c[0] + '|' + c[2];
	$(dp).parent().find('.mbcdp_monthyear').html(val);
	mms_datepicker_draw_cal(dp);
	$(dp).parent().find('.mbcdp_stage').show();
}

function mms_datepicker_draw_cal(dp){
	var current_day=$(dp).val().split('/')[1]*1;
	var current_mon=$(dp).val().split('/')[0]*1;
	var current_year=$(dp).val().split('/')[2]*1;
	var my=$(dp).parent().find('.mbcdp_monthyear').html();
	var c=my.split('|');
	var mon=c[0];
	var yr=c[1];
	var mon_labels='*,JAN,FEB,MAR,APR,MAY,JUN,JUL,AUG,SEPT,OCT,NOV,DEC'.split(',');
	$(dp).parent().find('.mbcdp_month_disp').html(mon_labels[mon*1] + ' ' +yr);

	var days_in_month=new Date(yr, mon, 0).getDate();
	var month_start_day = new Date(yr,(mon-1),1).getDay();
	// 6 - Saturday
	var html='<tr>';
	var total_days=days_in_month+month_start_day-1;
	weeks=0;
	for (i=0;i<=total_days;i++){
		var dy=i-month_start_day+1;
		if (i%7==0){
			html+='</tr><tr>';
			weeks++;
		}
		if (i<month_start_day){
			html+='<td>&nbsp;</td>';
		} else {
			html+='<td><a href="#" tabindex="-1" onclick="mms_datepicker_select(this);return false;" class="mbcdp_day';
			if ( (dy==current_day) && (mon==current_mon) && (yr==current_year) ){
				html+=' mbcdp_active_day ';
			}
			html+='">' + dy + '</a></td>';
		}
	}
	var leftoverdays=6-total_days%7;
	for (i=0;i<leftoverdays;i++){
		html+='<td>&nbsp;</td>';
	}
	html+='</tr>';
	if (weeks<6){
		html+='<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
	}
	$(dp).parent().find('tbody').html(html);
}

function mms_datepicker_select(obj){
	dp=$(obj).parent().parent().parent().parent().parent();
	var d=$(obj).html()*1;
	var my=$(dp).parent().find('.mbcdp_monthyear').html();
	var c=my.split('|');
	var mon=c[0];
	var yr=c[1];
	$(dp).parent().find('.datepicker').val(mms_zpad(mon) + '/' + mms_zpad(d) + '/' + mms_zpad(yr) );
	$(dp).hide();
}

function mms_datepicker_month_change(dir,obj){
	dp=$(obj).parent().parent().parent().find('.datepicker');
	var my=$(dp).parent().find('.mbcdp_monthyear').html();
	var c=my.split('|');
	var mon=c[0];
	var yr=c[1];
	mon*=1;
	mon+=dir;
	if (mon<1){
		mon=12;yr--;
	}
	if (mon>12){
		mon=1;yr++;
	}
	$(dp).parent().find('.mbcdp_monthyear').html(mon + '|' + yr);
	mms_datepicker_draw_cal(dp);
}


function mms_datepicker_init(dp){
	var html='';
	html+='<div class="mbcdp_stage ';
	if ($(dp).hasClass('datepicker-below')){
		html+='datepicker-below';
	}
	html+='"><div class="mbcdp_monthyear"></div><div class="mbcdp_toprow"><a href="#" class="prev" tabindex="-1" onclick="mms_datepicker_month_change(-1,this);return false;">&lt;</a><div class="mbcdp_month_disp">MONTH 2017</div><a href="#" class="next" tabindex="-1" onclick="mms_datepicker_month_change(1,this);return false;">&gt;</a></div>';
	html+='<table class="mbcdp_calendar"><thead><th>Sn</th><th>Mn</th><th>Tu</th><th>Wd</th><th>Th</th><th>Fr</th><th>St</th></thead><tbody></tbody></table></div>';
	html+='';
	$(dp).parent().append(html);
	mms_datepicker_clean_input(dp);
	$(dp).focus(function(){
		mms_datepicker_launch($(this));
	});
	$(dp).blur(function(){
		mms_datepicker_cancel($(this));
	});
}

function mms_datepicker_init_stage(){
	var html='<link href="/js/mms_datepicker/mms_datepicker.css" rel="stylesheet" id="mms_datepicker_style">';
	$('body').append(html);
	$('input').each(function(){
		if (!$(this).hasClass('datepicker')){
			$(this).focus(function(){
				$('.datepicker').parent().find('.mbcdp_stage').hide();
			});
		}
	});

}

$(function() {
	var mms_active_id='';
	$('form').each(function(){
        if ($(this).find('.datepicker').length>0){
            $(this).submit(function( event ) {
                $('.datepicker').each(function(){
                    var d=$(this).val().split('/');
                    $(this).val(mms_zpad(d[2]) + '-' + mms_zpad(d[0]) + '-' + mms_zpad(d[1]) );
                });
            });
        }
	});
	$('.datepicker').each(function(){
		mms_datepicker_init($(this));
	});
	if ($('.datepicker').length>0){
		mms_datepicker_init_stage();
	}

});
