<!DOCTYPE HTML>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>US Sailing - Sail Measurements</title>
	<style>
		@import url(http://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic,900,900italic,300italic,300,100italic,100);
		body {font-family:'Roboto';font-weight:300}
		h1 {font-size:20px}
		input[type=text] {width:90%}
		/*.left_column, .right_column {float:left}*/
		.left_column {width:500px; display: none;}
		.right_column {width:700px; margin-bottom: 30px;}
		.certificate {clear:both}
		.formRow {clear:both}
		.formLabel, .formLabelAbbreviation, .inputField {float:left}
		.formLabel {font-weight:bold;width:200px}
		.formLabelAbbreviation {font-weight:bold;width:84px}
		.formHeader {font-weight:bold}
		.inputField {width:200px}
		.submitRow {display:none;padding-top:20px}
		.submitBtn, .clearBtn {width:auto;float:left}
		.clearBtn {margin-left:20px}
		#email_button {display:none;}
        .error {font-family:"Arial"; font-size:x-small; color: red}


		.hidden { visibility:hidden}

		.panel {
			padding:7px;
			margin:10px;
			vertical-align:top;

	 		border: 1px solid black;
	 		border-radius:5px;
	 		width:30%;
	 		display:inline-block;
		}

		path {
			fill:none;
		}
		
		.line1 {
			stroke-width:1.5;
			stroke: #128cbd;	
		}
		.line2 {
			stroke-width:1.1;
			stroke: #aaa;	
		}
		.dotted-line {
			stroke-width:1;
			stroke: #F33;
			stroke-dasharray: 2,1;	
		}		

		.black-line {
			stroke-width:1;
			stroke: #333;	
		}

		.dummy-line {
			stroke-width:0;
		}

		.arrow {	
			marker-end : url(#arrow);
		}
		.double-arrow {	
			marker-end : url(#arrow);
			marker-start : url(#start-arrow);
		} 

        #graph {
	        width:350px;
	        height:350px;
	        margin:8px;
        }

        .label-text {
	        font-family:"Arial"; 
            font-size: 0.4em;
	        text-anchor: middle;
        }

        div#notLegalMsg div {
            padding-top: 10px;
            margin-left: 210px;
            text-align: center;
            width: auto;
            color: red;
            font-weight: bolder;
        }


        /*
        .calc_container{font-size: smaller;
            display:none;
        }*/


        .calc_container>div{
			padding: 10px;
			border: 1px solid #9E9E9E;
		}

		.calc_container,.panel-left, #asym_spinnaker_cont, #asym-1_calcs_cont{
		/*	display: flex;*/
			flex-wrap: wrap;
		}

        .calc_container div{
            margin-bottom: 10px;
            margin-right: 10px;        
        }

        .calc_container table:not(last-child){
            margin-bottom: 10px;
        }

        .calc_container .panel-left>div, .calc_container #asym_spinnaker, .calc_container #asym_spinnaker_cont, .calc_container .tablecont_right, .calc_container .panel-right{
            margin-right: 0;
        }
		table{
			border: 1px solid #607D8B;
			border-collapse: collapse;
		}

        #inputs thead {
            background-color: #CCFFCC;
        }

		tr, td, th{
			border: 1px solid #607D8B;
		}

		th,td{
			text-align: center;
			padding: 2px 6px;
			box-sizing: border-box;
			border: inherit;
			
		}

        td{width:50px;}

        
        tbody th {
            min-width: 106px;
        }

        .panel-right tbody th {
            min-width: 112px;
        }


	</style>
	<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
	<script src="https://d3js.org/d3.v5.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js"></script>

	<script>

		function $$(el,val,precision = 2) { 
			var eln = d3.select('#'+el);                            
			if(val !== undefined) {
                eln.datum(val);      
                var valx = precision && !isNaN(parseFloat(val)) ? ROUND(val,precision) : val;
                eln.node().tagName == 'INPUT' ? eln.attr('value',valx)  : eln.text(valx) ;                    
            }    			
			return eln.size() ? +eln.datum() || eln.attr('value') || eln.text(): 0;  
		}

		function $$$(el,val) { 
			var eln = d3.select('#'+el);                            
			if(val !== undefined) {
                eln.text(val);                    
            }
			return eln.size() ? eln.text() : '';  
		}      

		function ROUND(number, decimals = 2) { 
						
            var acc=10**decimals;
            return (Math.round(number*acc)/acc).toFixed(decimals);			
            	
		}

		function AND() { 
			for (var i = 0; i < arguments.length; i++) {
				if(!arguments[i]) return false;  }
			return true;	
		}
		function OR() { 
			for (var i = 0; i < arguments.length; i++) {
				if(arguments[i]) return true;  }
			return false;	
		}		
		function SUM(arr) { return arr.reduce((a,b) => a + b, 0) }
		function IF(constr,p1,p2) { return constr ? p1 : p2 }
		function SET(name,i1,i2) { 
			var data = [];
			for(var i=i1;i<=i2;i++) data.push ( +$$(name + i) )
			return data;
		}

		function MAX(arr) {	return d3.max(arr);	}
		function MIN(arr) {	return d3.min(arr);	}
		function SQRT(n) { return Math.sqrt(n); }
		function COS(n) { return Math.cos(n); }
		function SIN(n) { return Math.sin(n); }
		function TAN(n) { return Math.tan(n); }
		function ACOS(n) { return Math.acos(n); }
		function RADIANS(n) { return n /180 * Math.PI; }
		function DEGREES(n) { return n*180/Math.PI; }
		function POW(n,m) { return Math.pow(n,m); }
		function ABS(n) { return Math.abs(n); }

		
		function drawGraph(el, xSet, ySet, xM, yM, showScales = false, classed = 'line1', label = '', reversedX = true) {

	
			var width = 360, height = 360, marginX = 25, marginY = 25,
				svg = el.selectAll('svg').data([1]).enter().append('svg')
						.attr('viewBox', "0 0 360 360")
						.append('g').attr('id','svg-g').attr("transform", "translate(" + [marginX,marginY/2] + ")")
                                .style('opacity',0),

   
					xScale, yScale, index = 1,
					defs = svg.selectAll('defs').data([1]).enter().append('defs');
  
                svg.transition().duration(400)
                    .style('opacity',1);

  				defs
	 				.append('marker')
	 				.attr('id', 'arrow')
	 					.attr('viewBox', '0 -5 10 10')
	 					.attr('refX', 10)
	 					.attr('markerWidth', 5)
	 					.attr('markerHeight', 5)
	 					.attr('orient', 'auto')
	 					.append('svg:path')
							.style("opacity", 0.9)
							.attr('d', 'M0,-5L10,0L0,5')
							.style('fill', 'red');
				defs
	 				.append('marker')
	 				.attr('id', 'start-arrow')
	 					.attr('viewBox', '0 -5 10 10')
	 					.attr('refX', 0)
	 					.attr('markerWidth', 5)
	 					.attr('markerHeight', 5)
	 					.attr('orient', 'auto')
	 					.append('svg:path')
							.style("opacity", 0.9)
							.attr('d', 'M10,-5L0,0L10,5')
							.style('fill', 'red');							
					
				if( svg.size() ) { // first run
					xScale = d3.scaleLinear().nice().range( reversedX ? [ width-marginX-marginX/2,0 ] :[0, width-marginX-marginX/2 ] )
						.domain( [ Array.isArray(xM) ? d3.min(xM) : d3.min(xSet), Array.isArray(xM) ? d3.max(xM) : d3.max(xSet)]),

					yScale = d3.scaleLinear().nice().range([height-marginY-marginY/2,0])		
						.domain( [ Array.isArray(yM) ? d3.min(yM) : d3.min(ySet), Array.isArray(yM) ? d3.max(yM) : d3.max(ySet)]),
					svg.datum({xScale:xScale,yScale:yScale, index:1});

				}else{
					xScale = el.select('#svg-g').datum().xScale,
					yScale = el.select('#svg-g').datum().yScale;
					index = ++el.select('#svg-g').datum().index;
				}
		
				line = d3.line().x(d => xScale(d.x)).y(d => yScale(d.y) ).curve(d3.curveCatmullRom)
				data = xSet.map( (d,i) => { return {x: d, y: ySet[i] } } );
				if(data.length < 2) { // use to draw just text label at predefined position
					if(label) el.select('#svg-g').append('text').attr('x',xScale(data[0].x)).attr('y', yScale(data[0].y))
						.attr('dy',-2).classed('label-text',true).text(label);
						return;				
				}

				if(showScales) {
					svg.append("g")
      					.attr("transform", "translate(" + [0,height-marginY-marginY/2] + ")")
      					.call(d3.axisBottom(xScale));
				  
					svg.append("g")
						.attr("transform", "translate(" + [0,0] + ")")
      					.call(d3.axisLeft(yScale));
				}  

			var id = el.attr('id') + index;
			el.select('#svg-g').append("path").classed(classed, true).attr('id',id).attr("d", line(data));
			if(label) el.select('#svg-g').append('text').attr('dy',-2).classed('label-text',true).append('textPath')
				.attr('side','left').attr('startOffset','40%').attr('href', '#' + id).text(label);
			
		}
	
		function calcChartData() {
			"use strict";

			d3.select('svg').remove();       
            d3.select('#left').style('opacity',0);     		

			let boatName = $("input[name=boat_name]").val();
			let	sailNumber = $("input[name=sail_number]").val();
			let	classModel = $("input[name=class_model]").val();
			let	owner = $("input[name=owner]").val();
			let	sailDescription = $("input[name=sail_description]").val();
			let	sailIDNumber = $("input[name=sail_id_number]").val();
			let	loft = $("input[name=loft]").val();
			let	measurerName = $("input[name=measurer_name]").val();
			let	date = $("input[name=date]").val();
			let	signature = $("input[name=signature]").val();

			let ifmeters = $('input[type=radio][name=measurement_units]:checked').val();
			let S1 = (ifmeters == 'meters');
			let SD_K5 = +$("input[name=meters_luff_length]").val();
			let	SD_K6 = +$("input[name=meters_leech_length]").val();
			let	SD_K7 = +$("input[name=meters_half_width]").val();
            let	SD_K8 = +$("input[name=meters_foot_length]").val();		
            
                
			$("input[name=meters_luff_length]").val( IF(SD_K5, ROUND(SD_K5),''));
			$("input[name=meters_leech_length]").val( IF(SD_K6, ROUND(SD_K6),''));
			$("input[name=meters_half_width]").val( IF(SD_K7, ROUND(SD_K7),''));
			$("input[name=meters_foot_length]").val( IF(SD_K8, ROUND(SD_K8),''));
				
			$$$('dataCol1', S1 ? 'Meters' : 'Feet');
			$$$('dataCol2', !S1 ? 'Meters' : 'Feet');	

			const multiplier = 3.28084;
				
			let SD_L5 = $$('SD_L5', IF(SD_K5,IF(S1,SD_K5/0.3048,SD_K5*0.3048),""),2);
			let	SD_L6 = $$('SD_L6', IF(SD_K6,IF(S1,SD_K6/0.3048,SD_K6*0.3048),""),2);
			let	SD_L7 = $$('SD_L7', IF(SD_K7,IF(S1,SD_K7/0.3048,SD_K7*0.3048),""),2);
            let	SD_L8 = $$('SD_L8', IF(SD_K8,IF(S1,SD_K8/0.3048,SD_K8*0.3048),""),2);
            
            //=ЕСЛИ(K7>=0.75*K8,"","THIS IS NOT A LEGAL SPINNAKER")
            let notLegalMsg=(SD_K7>=(0.75*SD_K8))?"":"<div>THIS IS NOT A LEGAL SPINNAKER<br>HALF WIDTH < 0.75 x FOOT<br>SAIL MUST BE MEASURED AS A HEADSAIL</div>";
             $("#notLegalMsg").html(notLegalMsg);

            console.log("SD_L5: "+SD_L5);
                
				
			let metersLuffLength = $("input[name=meters_luff_length]").val();
			let metersLeechLength = $("input[name=meters_leech_length]").val();
			let metersHalfWidth = $("input[name=meters_half_width]").val();
			let metersFootLength = $("input[name=meters_foot_length]").val();
			
			let feetLuffLength = $("input[name=feet_luff_length]").val();
			let feetLeechLength = $("input[name=feet_leech_length]").val();
			let feetHalfWidth = $("input[name=feet_half_width]").val();
			let feetFootLength = $("input[name=feet_foot_length]").val();		            
 
			const Assumed_Tack_Angle_d=69;
			const Tack_a_x = 0;
			const Tack_a_y=0;
			const Step_Inc=0.01;
			const Foot_Offset_Factor=0.04;
			const SLE_Mid_Ext_Factor=0.5;
                                     
            let ASLU_1=+ROUND(SD_K5); 
            let ASLU_1a=+ROUND(SD_L5);
			let ASF_1=+ROUND(SD_K8);
            let ASF_1a=+ROUND(SD_L8);
            
            

        	let AMG_1=+ROUND(SD_K7); 
			let AMG_1a=+ROUND(SD_L7);
            let ASLE_1=+ROUND(SD_K6); 
            let ASLE_1a=+ROUND(SD_L6);						
                             
            let SLU_a=ASLU_1;
            
		
            let Tick_Offset=0.015*SLU_a;
			let Tick_Length=Tick_Offset*1.33;
			let SLE_a=ASLE_1;
	
			let SF_a=ASF_1;
		
			let SHW_a=AMG_1;
			let ASL_1 = (ASLU_1>0 && ASLE_1>0) ? +ROUND((0.5*(ASLU_1+ASLE_1))):'';
		
			let	ASL_1a=null;

				
            if(ASLU_1>0 && ASLE_1>0){
                ASL_1a=S1?+ROUND((ASL_1/0.3048)):+ROUND((ASL_1*0.3048));
			}
		
				
            let meters_area_irc;
			let meters_area_orc_orr;
			let feet_area_irc;
			let feet_area_orc_orr;

            if (ASLU_1>0 && ASLE_1>0 && AMG_1>0 && ASF_1>0){
				meters_area_irc = ((ASLU_1 + ASLE_1)/2)*((ASF_1+(4*AMG_1))/5)*0.83;
                meters_area_orc_orr = ASL_1*(0.5*ASF_1 + 2*AMG_1)/3;
                feet_area_irc = ((ASLU_1a + ASLE_1a)/2) * ((ASF_1a + (4 * AMG_1a))/5) * 0.83;
				feet_area_orc_orr = ASL_1a*(0.5*ASF_1a + 2*AMG_1a)/3;

              
                $("input[name='meters_area_irc']").val(ROUND(meters_area_irc));
                $("input[name='meters_area_orc_orr']").val(ROUND(meters_area_orc_orr));
                $("input[name='feet_area_irc']").val(ROUND(feet_area_irc));
                $("input[name='feet_area_orc_orr']").val(ROUND(feet_area_orc_orr));
                
                /*let SD_K9 = $$("SD_K9",meters_area_irc,2);
                let SD_K10 = $$("SD_K10",meters_area_orc_orr,2);
                let SD_L9 = $$("SD_L9",feet_area_irc,2);
                let SD_L10 = $$("SD_L10",feet_area_orc_orr,2);*/
                
			}else{
                $("input[name='meters_area_irc']").val("");
                $("input[name='meters_area_orc_orr']").val("");
                $("input[name='feet_area_irc']").val("");
                $("input[name='feet_area_orc_orr']").val("");
            }

            				
			if(!SD_K5 || !SD_K6 || ! SD_K7 || !SD_K8)  return false;
			
			d3.select("#calc-results").classed('hidden',false);
			d3.select('#left').transition().duration(300).style('opacity',1);
               
            				
                //let Tack_Angle_a_r=ACOS((POW(SF_a,2)+POW(SLU_a,2)-POW(SLE_a,2))/(2*SF_a*SLU_a));

                //sometimes it can't take acos because the value slightly exceeds 1
               
                let Tack_Angle_a_r=ACOS(ROUND(POW(SF_a,2)+POW(SLU_a,2)-POW(SLE_a,2))/(2*SF_a*SLU_a));



                console.log("SF_a: "+SF_a);
                console.log("SLU_a: "+SLU_a);
                console.log("SLE_a: "+SLE_a);
                console.log("Tack_Angle_a_r: "+Tack_Angle_a_r);

				//let Tack_Angle_a_r=5;
                let Tack_Angle_a_d=DEGREES(Tack_Angle_a_r);
                
                let TAP_d=(Assumed_Tack_Angle_d>Tack_Angle_a_d)?Assumed_Tack_Angle_d:(65-2*(Assumed_Tack_Angle_d-Tack_Angle_a_d));
                let TAP_r=RADIANS(TAP_d);
                let Radians_90=RADIANS(90);
                let TAPer=TAP_r+Radians_90;
                let R46=DEGREES(TAPer);
                let Clew_a_x = SF_a*COS(TAP_r-Tack_Angle_a_r);
                console.log("Clew_a_x: "+Clew_a_x);
                let Clew_a_y = SF_a*Math.sin(TAP_r-Tack_Angle_a_r);
                //let Head_Angle_a_r=ACOS((SLE_a**2+SLU_a**2-SF_a**2)/(2*SLE_a*SLU_a));
                let Head_Angle_a_r=ACOS(ROUND(SLE_a**2+SLU_a**2-SF_a**2)/(2*SLE_a*SLU_a));
                
                
                let Head_Angle_a_d=DEGREES(Head_Angle_a_r);
                let Head_a_x=COS(TAP_r)*SLU_a;
                let Head_a_y=Math.sin(TAP_r)*SLU_a;
                let R14=RADIANS(180)-Tack_Angle_a_r-Head_Angle_a_r;
                let Clew_Angle_a_d=DEGREES(R14);
                let Clew_Height_Angle_r=TAP_r-Tack_Angle_a_r;
                let Clew_Height_Angle_d=DEGREES(Clew_Height_Angle_r);
                let SLU_Mid_x=0.5*SLU_a*COS(TAP_r);
                let SLU_Mid_y=0.5*SLU_a*Math.sin(TAP_r);
                let SLU_Offset_to_Half_Leech_Factor=1.7*(SHW_a/SF_a)*(SHW_a/SLU_a)*0.15;
                let SLU_Offset_Length=SLU_Offset_to_Half_Leech_Factor*SLU_a;
                let FAPer=Clew_Height_Angle_r-Radians_90;
                let Foot_Offset_Distance=Foot_Offset_Factor*SF_a;
                let Mid_Foot_x=(0.5*SF_a)*COS(Clew_Height_Angle_r);
                let Mid_Foot_y=(0.5*SF_a)*Math.sin(Clew_Height_Angle_r);
            
                let Foot_Offset_x=Mid_Foot_x+(Foot_Offset_Distance*COS(Clew_Height_Angle_r+RADIANS(-90)));
                
                let Foot_Offset_y=Mid_Foot_y+(Foot_Offset_Distance*Math.sin(Clew_Height_Angle_r+RADIANS(-90)));
            
                let Ext_SLE_Angle_r=RADIANS(180)-TAP_r-Head_Angle_a_r;
                let Ext_SLE_Angle_d=DEGREES(Ext_SLE_Angle_r);
                let I37=TAP_r+Head_Angle_a_r;
                let I38=DEGREES(I37);
                let LAPer=I37-Radians_90;
                let R49=DEGREES(LAPer);
            
                let SLU_Half_Leech_Point_x=SQRT((0.5*SLU_a)**2+SLU_Offset_Length**2)*COS(TAP_r+Math.atan(SLU_Offset_Length/(0.5*SLU_a)));
            
                let SLU_Half_Leech_Point_y=SQRT((0.5*SLU_a)**2+SLU_Offset_Length**2)*Math.sin(TAP_r+Math.atan(SLU_Offset_Length/(0.5*SLU_a)));

                let SLU_Half_Luff_a_x=SLU_Half_Leech_Point_x;
                let SLU_Half_Luff_a_y=SLU_Half_Leech_Point_y;

                let SLE_Mid_x=Clew_a_x-(0.5*SLE_a)*COS(Ext_SLE_Angle_r);
                let SLE_Mid_y=Clew_a_y+(0.5*SLE_a)*Math.sin(Ext_SLE_Angle_r);

                let V4=SLE_Mid_x; 
                let W4=SLE_Mid_y;
                let V5=SLU_Offset_Length;
                let W6=0.75;
                let V6=W6*V5;
                let W7=1.25;
                let V7=W7*V5;

                /**500-lines table */

                let x_500val=[];
                let y_500val=[];
                let dist_500val=[];
                let SLE_Mid_Luff_Angle=RADIANS(180)-Ext_SLE_Angle_r-Radians_90;
                let SLE_Mid_Luff_Angle_r=SLE_Mid_Luff_Angle;
                let Start_for_int_x=SLE_Mid_x+V6*COS(SLE_Mid_Luff_Angle_r);
                let Start_for_int_y=SLE_Mid_y+V6*Math.sin(SLE_Mid_Luff_Angle_r);

                let V12=SQRT((Start_for_int_x-SLU_Half_Luff_a_x)**2+(Start_for_int_y-SLU_Half_Luff_a_y)**2);
                
                let tmp_x=null;
                let tmp_y=null;
                let tmp_dist=null;
                let SHW_Intercept_x=null;
                let SHW_Intercept_y=null;
                let SHW_Intercept_dist=null;
                let nodes=[];
                let R48=I37-Radians_90;

                for(let i=1;i<=500;i++){

                    tmp_x=Start_for_int_x+i*Step_Inc*COS(SLE_Mid_Luff_Angle_r);
                    x_500val.push(tmp_x);
                    tmp_y=Start_for_int_y+i*Step_Inc*Math.sin(SLE_Mid_Luff_Angle_r);
                    y_500val.push(tmp_y);
                    tmp_dist=SQRT((tmp_x-SLU_Half_Luff_a_x)**2+(tmp_y-SLU_Half_Luff_a_y)**2);
                    nodes.push({x: tmp_x, y: tmp_y});

                    $("table#500val tbody").append("<tr><th>"+i+"</th><td>"+ROUND(tmp_dist,3)+"</td><td>"+ROUND(tmp_x,3)+"</td><td>"+ROUND(tmp_y,3)+"</td></tr>");

                    if(ROUND(tmp_dist,2)==SHW_a){
                        SHW_Intercept_x=tmp_x;
                        SHW_Intercept_y=tmp_y;
                        SHW_Intercept_dist=tmp_dist;                        
                    }
                }
               
                let SLE_Half_Luff_x=SHW_Intercept_x;
                let SLE_Half_Luff_y=SHW_Intercept_y;
                let I4=Tack_a_x;
                let J4=Tack_a_y;
                let I9=Tack_a_x;
                let J9=Tack_a_y;
                let I10=SLU_Half_Luff_a_x;
                let J10=SLU_Half_Luff_a_y;
                let I11=0.37*(Head_a_x-SLU_Half_Luff_a_x)+SLU_Half_Luff_a_x;
                let J11=0.6*(Head_a_y-SLU_Half_Luff_a_y)+SLU_Half_Luff_a_y;
                let I12=Head_a_x;
                let J12=Head_a_y;
                let I13=Head_a_x;
                let J13=Head_a_y;
                let I14=SHW_Intercept_x;
                let J14=SHW_Intercept_y;
                let I15=Clew_a_x;
                let J15=Clew_a_y;
                let I16=Clew_a_x;
                let J16=Clew_a_y;
                let I17=Foot_Offset_x;
                let J17=Foot_Offset_y;
                let I18=Tack_a_x;
                let J18=Tack_a_y;
                     
                let I55=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(Head_a_x+Tick_Offset*COS(TAPer)):0;

                let I56=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(I55+Tick_Length*COS(TAPer)):0;

                let I59=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(I55+0.5*Tick_Length*COS(TAPer)):0;
                let I21=I59;

                let I57 = (SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(Tack_a_x+Tick_Offset*COS(TAPer)):0;

                let I58 = (SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(I57+Tick_Length*COS(TAPer)):0;

                let I60 = (SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(I57+0.5*Tick_Length*COS(TAPer)):0;
                
                let I20=I60;

                let I64=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(Clew_a_x+Tick_Offset*COS(LAPer)):0;
                let I65=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(I64+Tick_Length*COS(LAPer)):0;
                let I67=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(I64+0.5*Tick_Length*COS(LAPer)):0;
                let I22=I67;

                let I62=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(Head_a_x+Tick_Offset*COS(LAPer)):0;
                let I63=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(I62+Tick_Length*COS(LAPer)):0;
                let I66=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(I62+0.5*Tick_Length*COS(LAPer)):0;

                let I23=I66;
                let I71=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(Tack_a_x+(0.5*Foot_Offset_Distance+Tick_Offset)*COS(FAPer)):0;
                let I72=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(I71+Tick_Length*COS(FAPer)):0;
      
                let I74=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(I71+0.5*Tick_Length*COS(FAPer)):0;
                let I26=I74;
                
                let I69=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(Clew_a_x+(0.5*Foot_Offset_Distance+Tick_Offset)*COS(FAPer)):0;
                let I70=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(I69+Tick_Length*COS(FAPer)):0;
                let I73=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(I69+0.5*Tick_Length*COS(FAPer)):0;
                let I27=I73;
                
                //let J18=Tack_a_y;
                
                let J57=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(Tack_a_y+Tick_Offset*Math.sin(TAPer)):0;
                let J58=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(J57+Tick_Length*Math.sin(TAPer)):0;

                let J60=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(J57+0.5*Tick_Length*Math.sin(TAPer)):0;
                let J20=J60;
                let J55=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(Head_a_y+Tick_Offset*Math.sin(TAPer)):0;
                let J56=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(J55+Tick_Length*Math.sin(TAPer)):0;

                let J59=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(J55+0.5*Tick_Length*Math.sin(TAPer)):0;
                let J21=J59;
                let J64=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(Clew_a_y+Tick_Offset*Math.sin(LAPer)):0;
                let J65=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(J64+Tick_Length*Math.sin(LAPer)):0;
                let J67=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(J64+0.5*Tick_Length*Math.sin(LAPer)):0;
                let J22=J67;
                let J62=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(Head_a_y+Tick_Offset*Math.sin(LAPer)):0;
                let J63=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(J62+Tick_Length*Math.sin(LAPer)):0;
                let J66=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(J62+0.5*Tick_Length*Math.sin(LAPer)):0;
                let J23=J66;
                let J71=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(Tack_a_y+(0.5*Foot_Offset_Distance+Tick_Offset)*Math.sin(FAPer)):0;
                let J72=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(J71+Tick_Length*Math.sin(FAPer)):0;
                let J74=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(J71+0.5*Tick_Length*Math.sin(FAPer)):0;
                let J26=J74;
                let J69=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(Clew_a_y+(0.5*Foot_Offset_Distance+Tick_Offset)*Math.sin(FAPer)):0;
                let J70=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(J69+Tick_Length*Math.sin(FAPer)):0;
                let J73=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?(J69+0.5*Tick_Length*Math.sin(FAPer)):0;
                let J27=J73;
                
                let AS_data_maxx=Math.max(Tack_a_x,Clew_a_x,Head_a_x,SLU_Half_Luff_a_x,I11,SHW_Intercept_x,Foot_Offset_x,I20,I21,I22,I23,SLU_Half_Leech_Point_x,I26,I27);
                
                let AS_data_minx=Math.min(Tack_a_x,Clew_a_x,Head_a_x,SLU_Half_Luff_a_x,I11,SHW_Intercept_x,Foot_Offset_x,I20,I21,I22,I23,SLU_Half_Leech_Point_x,I26,I27);
               
              
                let AS_xdata_range=AS_data_maxx-AS_data_minx;

                let AS_data_maxy=Math.max(Tack_a_y,Clew_a_y,Head_a_y,SLU_Half_Luff_a_y,J11,SHW_Intercept_y,Foot_Offset_y,J20,J21,J22,J23,SLU_Half_Leech_Point_y,J26,J27);
                
                let AS_data_miny=Math.min(Tack_a_y,Clew_a_y,Head_a_y,SLU_Half_Luff_a_y,J11,SHW_Intercept_y,Foot_Offset_y,J20,J21,J22,J23,SLU_Half_Leech_Point_y,J26,J27);

                let AS_ydata_range=AS_data_maxy-AS_data_miny;
                let I32=Math.asin((Head_a_y-Tack_a_y)/SLU_a);
                let I33=DEGREES(I32);
                let I35=0.65;
                let SLU_Label_mid_x=I35*SLU_a*COS(I32)+I20;
                let SLU_Label_mid_y=I35*SLU_a*Math.sin(I32)+J20;
                let I40=0.6;
                let I39=I40*SLE_a*COS(I37)+I22;
                let J39=I40*SLE_a*Math.sin(I37)+J22;
                let G32=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?"Luff Length":"";
                let G37=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?"Leech Length":"";
                let G42=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?"Half Width":"";
                let G48=(SLU_a>0 && SLE_a>0 && SHW_a>0 && SF_a>0)?"Foot Length":"";
                let I42=Math.asin((SLE_Half_Luff_y-SLU_Half_Luff_a_y)/SHW_a);
                let I43=DEGREES(I42);
                let SHW_mid_x=0.5*SHW_a*COS(I42)+SLU_Half_Luff_a_x;
                let SHW_mid_y=0.5*SHW_a*Math.sin(I42)+SLU_Half_Luff_a_y;
                let I45=0.9;
                let I46=SHW_mid_x;
                let J46=I45*SHW_mid_y;

                let I48=0.5*SF_a*COS(Clew_Height_Angle_r)+I74;
                let I49=0.9;
                let I50=I48+I49*COS(FAPer);

                let J48=0.5*SF_a*Math.sin(Clew_Height_Angle_r)+J74;
                let J50=J48+I49*Math.sin(FAPer);

                let AS_axes_minx=-(AS_ydata_range-AS_xdata_range)/2;
                let AS_axes_maxx=AS_ydata_range+AS_axes_minx;
                let M13=AS_axes_minx-AS_axes_maxx;
                let AS_axes_maxy=AS_data_maxy;
                let AS_axes_miny=AS_data_miny;
                let N13=AS_axes_maxy-AS_axes_miny;
                let AS_dummy_hor_maxx=AS_axes_maxx;
                let AS_dummy_hor_maxy=AS_axes_miny;
                let AS_dummy_hor_minx=AS_axes_minx;
                let AS_dummy_hor_miny=AS_axes_miny;
                let AS_dummy_vert_maxx=AS_axes_minx;
                let AS_dummy_vert_maxy=AS_axes_miny;
                let AS_dummy_vert_minx=AS_axes_minx;
                let AS_dummy_vert_miny=AS_axes_maxy;

                let SLE_Mid_Ext_Distance=SLE_Mid_Ext_Factor*SLE_a;

                let SLE_Mid_Ext_x=SLE_Mid_x+SLE_Mid_Ext_Distance*COS(SLE_Mid_Luff_Angle_r);
                let SLE_Mid_Ext_y=SLE_Mid_y+SLE_Mid_Ext_Distance*Math.sin(SLE_Mid_Luff_Angle_r);

                let R40=SHW_a;

                let R52=DEGREES(FAPer);
			
	//			drawGraph( d3.select('#graph-boat'), [ I9,I10,I11,I12,I13,I14,I15,I16,I17,I18, 
	//			        AS_dummy_hor_maxx, AS_dummy_hor_minx, AS_dummy_vert_maxx, AS_dummy_vert_minx ],
     //           [ J9,J10,J11,J12,J13,J14,J15,J16,J17,J18, AS_dummy_hor_maxy, AS_dummy_hor_miny, AS_dummy_vert_maxy, AS_dummy_vert_miny ],0,0,0,'dummy-line');	// Dummy Hor



//console.log([  
//				        AS_dummy_hor_maxx, AS_dummy_hor_minx, AS_dummy_vert_maxx, AS_dummy_vert_minx ],
  //              [  AS_dummy_hor_maxy, AS_dummy_hor_miny, AS_dummy_vert_maxy, AS_dummy_vert_miny ])
    
     drawGraph( d3.select('#graph-boat'), [  I9,I10,I11,I12,I13,I15,I16,I17,I18,
        AS_dummy_hor_maxx, AS_dummy_hor_minx,AS_dummy_vert_maxx, AS_dummy_vert_minx    ],
                [    J9,J10,J11,J12,J13,J15,J16,J17,J18, AS_dummy_vert_maxy, AS_dummy_vert_miny,AS_dummy_hor_maxy, AS_dummy_hor_miny ],0,0,0,'dummy-line');	// Dummy Hor
		

				//drawGraph( d3.select('#graph-boat'), [ I9,I10,I11,I12,I13,I14,I15,I16,I17,I18 ],[ J9,J10,J11,J12,J13,J14,J15,J16,J17,J18 ]);	// LuffLeechFoot
                I14 ?
                    drawGraph( d3.select('#graph-boat'), [ I9,I10,I11,I12,I13,I14,I15,I16,I17,I18 ],[ J9,J10,J11,J12,J13,J14,J15,J16,J17,J18 ]) :	// LuffLeechFoot 
                    drawGraph( d3.select('#graph-boat'), [ I9,I10,I11,I12,I13,I15,I16,I17,I18 ],[ J9,J10,J11,J12,J13,J15,J16,J17,J18 ]);	// LuffLeechFoot

				drawGraph( d3.select('#graph-boat'), [ I20, I21 ],[ J20, J21 ],0,0,0,'dotted-line double-arrow');	// Luff Length
				
				drawGraph( d3.select('#graph-boat'), [ I22, I23],[ J22, J23 ],0,0,0,'dotted-line double-arrow');	// Leech Length

				drawGraph( d3.select('#graph-boat'), [ SLU_Half_Luff_a_x, SLE_Half_Luff_x ],[ SLU_Half_Luff_a_y, SLE_Half_Luff_y ],0,0,0,'dotted-line double-arrow');	// SHW

				drawGraph( d3.select('#graph-boat'), [ I26, I27 ],[ J26, J27 ],0,0,0,'dotted-line double-arrow');	// Foot Length

				drawGraph( d3.select('#graph-boat'), [ I55, I56 ],[ J55, J56 ],0,0,0,'black-line');	// LuffTopTick
				drawGraph( d3.select('#graph-boat'), [ I57, I58 ],[ J57, J58 ],0,0,0,'black-line');	// LuffBotTick
				drawGraph( d3.select('#graph-boat'), [ I62, I63 ],[ J62, J63 ],0,0,0,'black-line');	// LeechTickTop
				drawGraph( d3.select('#graph-boat'), [ I64, I65 ],[ J64, J65 ],0,0,0,'black-line');	// LeechTickBot
				drawGraph( d3.select('#graph-boat'), [ I69, I70 ],[ J69, J70 ],0,0,0,'black-line');	// FootTickLeft
				drawGraph( d3.select('#graph-boat'), [ I71, I72 ],[ J71, J72 ],0,0,0,'black-line');	// FootTickRight
				

				if(notLegalMsg) return;
				drawGraph( d3.select('#graph-boat'), [ I39 ],[ J39 ],0,0,0,'',G37);	// Leech Length
				drawGraph( d3.select('#graph-boat'), [ SLU_Label_mid_x ],[ SLU_Label_mid_y ],0,0,0,'',G32);	// Luff Length
				drawGraph( d3.select('#graph-boat'), [ I46 ],[ J46 ],0,0,0,'','Half Width');	// Luff Length
				drawGraph( d3.select('#graph-boat'), [ I50 ],[ J50 ],0,0,0,'',G48);	// Foot Length			


return;

				$('#SHW_Intercept_x').text(ROUND(SHW_Intercept_x,3));
                $('#SHW_Intercept_y').text(ROUND(SHW_Intercept_y,3));
                $('#R41').text(ROUND(SHW_Intercept_dist,3));
                $('#R52').text(ROUND(R52));

                $("#R48").text(ROUND(R48));
                $("#R40").text(ROUND(R40));
                $("#SLE_Mid_Luff_Angle").text(ROUND(SLE_Mid_Luff_Angle));
                $("#FAPer").text(ROUND(FAPer));
                $("#SLU_Mid_y").text(ROUND(SLU_Mid_y));
                $("#SLU_Mid_x").text(ROUND(SLU_Mid_x));
                $("#Clew_Height_Angle_d").text(ROUND(Clew_Height_Angle_d));
                $("#Clew_Height_Angle_r").text(ROUND(Clew_Height_Angle_r));
                $("#Clew_Angle_a_d").text(ROUND(Clew_Angle_a_d));
                $("#R14").text(ROUND(R14));
                $("#Head_a_y").text(ROUND(Head_a_y));
                $("#Head_a_x").text(ROUND(Head_a_x));
                $("#Head_Angle_a_d").text(ROUND(Head_Angle_a_d));
                $("#Head_Angle_a_r").text(ROUND(Head_Angle_a_r));
                $("#Clew_a_y").text(ROUND(Clew_a_y));
                $("#Clew_a_x").text(ROUND(Clew_a_x));
                $("#R46").text(ROUND(R46));
                $("#TAPer").text(ROUND(TAPer));
                $("#TAP_r").text(ROUND(TAP_r));
                $("#TAP_d").text(ROUND(TAP_d));
                $("#Tack_Angle_a_d").text(ROUND(Tack_Angle_a_d));
                $("#Tack_Angle_a_r").text(ROUND(Tack_Angle_a_r));
                $("#SLU_Offset_to_Half_Leech_Factor").text(ROUND(SLU_Offset_to_Half_Leech_Factor));
                $("#SLU_Offset_Length").text(ROUND(SLU_Offset_Length));
                $("#Foot_Offset_Distance").text(ROUND(Foot_Offset_Distance));
                $("#Mid_Foot_x").text(ROUND(Mid_Foot_x));
                $("#Mid_Foot_y").text(ROUND(Mid_Foot_y));
                $("#Foot_Offset_x").text(ROUND(Foot_Offset_x));
                $("#Foot_Offset_y").text(ROUND(Foot_Offset_y));
                $("#Ext_SLE_Angle_r").text(ROUND(Ext_SLE_Angle_r));
                $("#Ext_SLE_Angle_d").text(ROUND(Ext_SLE_Angle_d));
                $("#I37").text(ROUND(I37));
                $("#I38").text(ROUND(I38));
                $("#LAPer").text(ROUND(LAPer));
                $("#R49").text(ROUND(R49));
                $("#Start_for_int_x").text(ROUND(Start_for_int_x,3));
                $("#Start_for_int_y").text(ROUND(Start_for_int_y,3));
                $("#V12").text(ROUND(V12,3));


                $("#SLU_a").text(SLU_a);
                $("#Tick_Offset").text(Tick_Offset);
                $("#Tick_Length").text(Tick_Length);
                $("#SLE_a").text(SLE_a);
                $("#SF_a").text(SF_a);
                $("#SHW_a").text(SHW_a);

                $("#V4").text(ROUND(V4));
                $("#W4").text(ROUND(W4));
                $("#V5").text(ROUND(V5));
                $("#W6").text(ROUND(W6));
                $("#V6").text(ROUND(V6));
                $("#W7").text(ROUND(W7));
                $("#V7").text(ROUND(V7));


                $('#AS_axes_maxx').text(ROUND(AS_axes_maxx));                 
                $('#AS_axes_minx').text(ROUND(AS_axes_minx));                 
                $('#M13').text(ROUND(M13));                 
                $('#AS_axes_maxy').text(ROUND(AS_axes_maxy));                 
                $('#AS_data_miny').text(ROUND(AS_data_miny));                 
                $('#AS_axes_miny').text(ROUND(AS_axes_miny));                 
                $('#N13').text(ROUND(N13));                 
                $('#AS_dummy_hor_maxx').text(ROUND(AS_dummy_hor_maxx));                 
                $('#AS_dummy_hor_maxy').text(ROUND(AS_dummy_hor_maxy));                 
                $('#AS_dummy_hor_minx').text(ROUND(AS_dummy_hor_minx));                 
                $('#AS_dummy_hor_miny').text(ROUND(AS_dummy_hor_miny));                 
                $('#AS_dummy_vert_maxx').text(ROUND(AS_dummy_vert_maxx));                 
                $('#AS_dummy_vert_maxy').text(ROUND(AS_dummy_vert_maxy));                 
                $('#AS_dummy_vert_minx').text(ROUND(AS_dummy_vert_minx));                 
                $('#AS_dummy_vert_miny').text(ROUND(AS_dummy_vert_miny));                 
                                          
                $('#I50').text(ROUND(I50));                 
                $('#I49').text(ROUND(I49));                 
                $('#I71').text(ROUND(I71));                 
                $('#I74').text(ROUND(I74));                 
                $('#I48').text(ROUND(I48));                 
                $('#J48').text(ROUND(J48));                 
                $('#J74').text(ROUND(J74));                 
                $('#J71').text(ROUND(J71));                 
                $('#J50').text(ROUND(J50));                 


                $('#SHW_mid_x').text(ROUND(SHW_mid_x));    
                $('#SHW_mid_y').text(ROUND(SHW_mid_y));    
                $('#I45').text(ROUND(I45));    
                $('#I46').text(ROUND(I46));    
                $('#J46').text(ROUND(J46));    

                $('#I4').text(ROUND(I4));    
                $('#I9').text(ROUND(I9));    
                $('#I10').text(ROUND(I10));    
                $('#I11').text(ROUND(I11));    
                $('#I12').text(ROUND(I12));    
                $('#I13').text(ROUND(I13));    
                $('#I14').text(ROUND(I14));    
                $('#I15').text(ROUND(I15));    
                $('#I16').text(ROUND(I16));    
                $('#I17').text(ROUND(I17));    
                $('#I18').text(ROUND(I18));    
                $('#I55').text(ROUND(I55));    
                $('#I59').text(ROUND(I59));    
                $('#I21').text(ROUND(I21));    
                $('#I57').text(ROUND(I57));     
                $('#I58').text(ROUND(I58));     
                $('#I60').text(ROUND(I60));    
                $('#I20').text(ROUND(I20));    
                $('#I64').text(ROUND(I64));    
                $('#I65').text(ROUND(I65));    
                $('#I67').text(ROUND(I67));    
                $('#I22').text(ROUND(I22));    
                $('#I62').text(ROUND(I62));    
                $('#I63').text(ROUND(I63));    
                $('#I66').text(ROUND(I66));    
                $('#I23').text(ROUND(I23));    
                $('#I71').text(ROUND(I71));    
                $('#I72').text(ROUND(I72));    
                $('#I74').text(ROUND(I74));    
                $('#I26').text(ROUND(I26));    
                $('#I69').text(ROUND(I69));    
                $('#I70').text(ROUND(I70));    
                $('#I73').text(ROUND(I73));    
                $('#I26').text(ROUND(I26));    
                $('#I27').text(ROUND(I27));    
                $('#I56').text(ROUND(I56));    
                $('#I32').text(ROUND(I32));    
                $('#I33').text(ROUND(I33));    
                $('#I35').text(ROUND(I35));    
                $('#I39').text(ROUND(I39));    
                $('#I40').text(ROUND(I40));    
                $('#I37').text(ROUND(I37));    
                $('#I42').text(ROUND(I42));    
                $('#I43').text(ROUND(I43));    
                
                $('#J4').text(ROUND(J4));    
                $('#J9').text(ROUND(J9));    
                $('#J10').text(ROUND(J10));    
                $('#J11').text(ROUND(J11));    
                $('#J12').text(ROUND(J12));    
                $('#J13').text(ROUND(J13));    
                $('#J14').text(ROUND(J14));    
                $('#J15').text(ROUND(J15));    
                $('#J16').text(ROUND(J16));    
                $('#J17').text(ROUND(J17));    
                $('#J18').text(ROUND(J18));    
                $('#J55').text(ROUND(J55));    
                $('#J56').text(ROUND(J56));    
                $('#J59').text(ROUND(J59));    
                $('#J21').text(ROUND(J21));    
                $('#J57').text(ROUND(J57));    
                $('#J58').text(ROUND(J58));    
                $('#J60').text(ROUND(J60));    
                $('#J20').text(ROUND(J20));    
                $('#J64').text(ROUND(J64));    
                $('#J65').text(ROUND(J65));    
                $('#J67').text(ROUND(J67));    
                $('#J22').text(ROUND(J22));    
                $('#J62').text(ROUND(J62));    
                $('#J63').text(ROUND(J63));    
                $('#J66').text(ROUND(J66));    
                $('#J23').text(ROUND(J23));    
                $('#J71').text(ROUND(J71));    
                $('#J72').text(ROUND(J72));    
                $('#J74').text(ROUND(J74));    
                $('#J26').text(ROUND(J26));    
                $('#J69').text(ROUND(J69));    
                $('#J70').text(ROUND(J70));    
                $('#J73').text(ROUND(J73));    
                $('#J26').text(ROUND(J26));    
                $('#J27').text(ROUND(J27));    
                $('#J39').text(ROUND(J39));    
                $('#SLU_Half_Leech_Point_x').text(ROUND(SLU_Half_Leech_Point_x));    
                $('#SLU_Half_Leech_Point_y').text(ROUND(SLU_Half_Leech_Point_y));    
                
                
                $('#G32').text(G32);    
                $('#G37').text(G37);    
                $('#G42').text(G42);    
                $('#G48').text(G48);    

                $('#SLU_Half_Luff_a_x').text(ROUND(SLU_Half_Luff_a_x));    
                $('#SLU_Half_Luff_a_y').text(ROUND(SLU_Half_Luff_a_y));    
                $('#SLE_Half_Luff_x').text(ROUND(SLE_Half_Luff_x));    
                $('#SLE_Half_Luff_y').text(ROUND(SLE_Half_Luff_y));    
                
                $('#SLU_Label_mid_x').text(ROUND(SLU_Label_mid_x));    
                $('#SLU_Label_mid_y').text(ROUND(SLU_Label_mid_y));    
                 
                $('#AS_data_maxx').text(ROUND(AS_data_maxx));
                $('#AS_data_minx').text(ROUND(AS_data_minx));
                $('#AS_xdata_range').text(ROUND(AS_xdata_range));
                
                $('#AS_data_maxy').text(ROUND(AS_data_maxy));
                $('#AS_data_miny').text(ROUND(AS_data_miny));
                $('#AS_ydata_range').text(ROUND(AS_ydata_range));
                $('#SLE_Mid_Ext_Distance').text(ROUND(SLE_Mid_Ext_Distance));
                $('#SLE_Mid_Ext_Factor').text(ROUND(SLE_Mid_Ext_Factor));
                $('#SLE_Mid_Ext_x').text(ROUND(SLE_Mid_Ext_x));
                $('#SLE_Mid_Ext_y').text(ROUND(SLE_Mid_Ext_y));
                $('#SLE_Mid_x').text(ROUND(SLE_Mid_x));
                $('#SLE_Mid_y').text(ROUND(SLE_Mid_y));
				
		}

		$( document ).ready(function() {

            
			var inputsInstant = ['meters_luff_length','meters_leech_length','meters_half_width','meters_foot_length','measurement_units' ];
		
			inputsInstant.forEach( d => $("input[name=" + d + "]").change( d => calcChartData()) )
				
			var validator =  $("#asymmetricSpinnakerForm").validate({
				rules: {
					boat_name: {
					  required: true
					},
					sail_number: {
					  required: true
					},
					class_model: {
					  required: true
					},
					owner: {
					  required: true
					},
					sail_description: {
					  required: true
					},
					sail_id_number: {
					  required: true
					},
					loft: {
					  required: true
					},
					measurer_name: {
					  required: true
					},
					date: {
					  required: true
					},
					signature: {
					  required: true
					},
					meters_luff_length: {
					  required: '#meters_measurement[value="meters"]:checked',
					  number: true,
					  min: 0
					},
					meters_leech_length: {
					  required: '#meters_measurement[value="meters"]:checked',
					  number: true,
					  min: 0
					},
					meters_half_width: {
					  required: '#meters_measurement[value="meters"]:checked',
					  number: true,
					  min: 0
					},
					meters_foot_length: {
					  required: '#meters_measurement[value="meters"]:checked',
					  number: true,
					  min: 0
					},
					feet_luff_length: {
					  required: '#feet_measurement[value="feet"]:checked',
					  number: true,
					  min: 0
					},
					feet_leech_length: {
					  required: '#feet_measurement[value="feet"]:checked',
					  number: true,
					  min: 0
					},
					feet_half_width: {
					  required: '#feet_measurement[value="feet"]:checked',
					  number: true,
					  min: 0
					},
					feet_foot_length: {
					  required: '#feet_measurement[value="feet"]:checked',
					  number: true,
					  min: 0
					},
				},
				submitHandler: function(form, event) { 
					event.preventDefault();
                    $("#email_button").show();		
				}
			});
			
            $(".feetField").prop("readonly", true);
            $(".feetField").prop("disabled", true);
            
            calcChartData();

			
			function sendData() {
				$("#email_button").hide();
				alert('Data sent.');
			}
			
			
			$("#clearForm").click(function() {
				event.preventDefault();
				if(confirm("Clear the form?")){
					$('#mainsailForm').trigger("reset");				
					calcChartData();
					validator.resetForm();
					$("#email_button").hide();	
					
				}
			});
			
			$("#emailData").click(function() {
				if(confirm("Send Data and Chart to US Sailing?")){
					sendData();
				}
			});
					
		});
	</script>
</head>

<body>

	<div class="certificate" id="mainsailCertificate">

	<h1>UMS Asymmetric Spinnaker Certificate</h1>

	<form id="asymmetricSpinnakerForm">
		
	<div class="left_column">
				<div class="formRow">
					<div class="formLabel">Boat Name:</div>
					<div class="inputField"><input type="text" name="boat_name" /></div>
				</div>
				<div class="formRow">
					<div class="formLabel">Sail No.:</div>
					<div class="inputField"><input type="text" name="sail_number" /></div>
				</div>
				<div class="formRow">
					<div class="formLabel">Class/Model:</div>
					<div class="inputField"><input type="text" name="class_model" /></div>
				</div>
				<div class="formRow">
					<div class="formLabel">Owner:</div>
					<div class="inputField"><input type="text" name="owner" /></div>
				</div>
				<div class="formRow">
					<div class="formLabel">Sail Desc.:</div>
					<div class="inputField"><input type="text" name="sail_description" /></div>
				</div>
				<div class="formRow">
					<div class="formLabel">Sail ID No.:</div>
					<div class="inputField"><input type="text" name="sail_id_number" /></div>
				</div>
				
				<div class="formRow">
					<div class="formLabel">Measurement Units:</div>
					<div>
						<input type="radio" id="meters_measurement" name="measurement_units" value="meters" checked /> Meters
						<input type="radio" id="feet_measurement" name="measurement_units" value="feet" /> Feet
					</div>
				</div>
				
				<div class="formRow">
					<div class="formLabel">Loft:</div>
					<div class="inputField"><input type="text" name="loft" /></div>
				</div>
		
				<div class="formRow">
					<div class="formLabel">Measurer Name:</div>
					<div class="inputField"><input type="text" name="measurer_name" /></div>
				</div>
				
				<div class="formRow">
					<div class="formLabel">Date:</div>
					<div class="inputField"><input type="text" name="date" value="<?php echo date('m/d/Y'); ?>" /></div>
				</div>
				
				<div class="formRow">
					<div class="formLabel">Signature:</div>
					<div class="inputField"><input type="text" name="signature" /></div>
				</div>
				
			</div>
			
			<div class="right_column">
			
				<div class="formRow">
					<div class="formLabel">&nbsp;</div>
					<div class="formLabelAbbreviation">&nbsp;</div>
					<div class="inputField formHeader" id="dataCol1"></div>
					<div class="inputField formHeader" id="dataCol2"></div>
				</div>
				
				<div class="formRow">
					<div class="formLabel">Luff Length</div>
					<div class="formLabelAbbreviation">SLU</div>
					<div class="inputField"><input type="text" name="meters_luff_length" class="metersField" id="SD_K5"/></div>
					<div class="inputField"><input type="text" name="feet_luff_length" class="feetField" id="SD_L5"/></div>
				</div>
				
				<div class="formRow">
					<div class="formLabel">Leech Length</div>
					<div class="formLabelAbbreviation">SLE</div>
					<div class="inputField"><input type="text" name="meters_leech_length" class="metersField" id="SD_K6"/></div>
					<div class="inputField"><input type="text" name="feet_leech_length" class="feetField" id="SD_L6"></div>
				</div>
				
				<div class="formRow">
					<div class="formLabel">Half Width</div>
					<div class="formLabelAbbreviation">SHW</div>
					<div class="inputField"><input type="text" name="meters_half_width" class="metersField" id="SD_K7" /></div>
					<div class="inputField"><input type="text" name="feet_half_width" class="feetField" id="SD_L7"/></div>
				</div>
				
				<div class="formRow">
					<div class="formLabel">Foot Length</div>
					<div class="formLabelAbbreviation">SFL</div>
					<div class="inputField"><input type="text" name="meters_foot_length" class="metersField" id="SD_K8"/></div>
					<div class="inputField"><input type="text" name="feet_foot_length" class="feetField" id="SD_L8" /></div>
				</div>
				
				<div class="formRow">
					<div class="formLabel">Area</div>
					<div class="formLabelAbbreviation">IRC</div>
					<div class="inputField"><input type="text" name="meters_area_irc" id="SD_K9" disabled /></div>
					<div class="inputField"><input type="text" name="feet_area_irc"  id="SD_L9" disabled /></div>
				</div>
				
				<div class="formRow">
					<div class="formLabel">Area</div>
					<div class="formLabelAbbreviation">ORC/ORR</div>
					<div class="inputField"><input type="text" name="meters_area_orc_orr"  id="SD_K10" disabled /></div>
					<div class="inputField"><input type="text" name="feet_area_orc_orr"  id="SD_L10" disabled /></div>
				</div>
                <div class="formRow " id="notLegalMsg">                     
                </div>
			
			</div>
			
			<div class="formRow submitRow">
				<div class="submitBtn">
					<input type="submit" value="Validate Data" />
				</div>
				<div class="clearBtn">
					<button id="clearForm">Clear Form</button>
				</div>
			</div>
		
		</form>
		
		<div id="chart"></div>
		
		<div class="formRow sendRow">
			<div id="email_button">
				Everything look good? <button id="emailData">Send Data to US Sailing</button>
			</div>
		</div>
		
	</div>


<div id="calc-results" class="hidden">

	<div id="left" class="panel">

		<div class="area" id="graph-boat"></div>
		
	</div>

</div>

<div class="calc_container">
        <div class="panel-left">

            <div class="panel-left-1">
                <div id="inputs">
                    <!--Inputs-->
                    <h2>Asym spinnaker</h2>
                    <table>
                        <thead>
                            <tr><th colspan="2">Inputs</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                            <th>SLU</td>
                            <td id="SLU_a">0</td> <!-- =ASLU_1 -->
                            </tr>
                            <tr>
                                <th>SLE</td> 
                                <td id="SLE_a">0</td>  <!-- =ASLE_1 -->
                            </tr>
                            <tr>
                                <th>AMG/SHW</td>
                                <td id="SHW_a">0</td> <!-- =AMG_1-->
                            </tr>
                            <tr>
                                <th>ASF/SF</td>
                                <td id="SF_a">0</td> <!--  =ASF_1     -->
                            </tr>
                        </tbody>    
                    </table>
                </div><!--inputs-->
            </div><!--panel-left-1-->

            <div class="panel-left-2">
                <div id="asym_spinnaker">
                    <h2>Asym spinnaker</h2>
                    <div id="asym_spinnaker_cont">
                        <div class="tablecont_left">
                            <table>
                                <thead>
                                    <tr>
                                        <th colspan="2"></th>
                                        <th>x</th>
                                        <th>y</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th rowspan="3"></th>
                                        <th>Tack</th>
                                        <td id="I4">0</td> 
                                        <td id="J4">0</td>
                                    </tr>
                                    <tr>
                                        <th>Clew</th>
                                        <td id="Clew_a_x"></td> 
                                        <td id="Clew_a_y"></td> 
                                    </tr>
                                    <tr>
                                        <th>Head</th>
                                        <td id="Head_a_x"></td> 
                                        <td id="Head_a_y"></td> 
                                    </tr>                                    
                                    <tr><th colspan="4"></th></tr>
                                    <tr>
                                        <th colspan="2"></th>
                                        <th>x</th>
                                        <th>y</th>
                                    </tr>                              
                                
                                    <!--luff-->
                                    <tr>
                                        <th rowspan="4">Luff</th>
                                        <th>Tack</th>
                                        <td id="I9">0</td>  
                                        <td id="J9">0</td>  
                                    </tr>
                                    <tr>                                        
                                        <th>SLU Half</th>
                                        <td id="I10"></td>  
                                        <td id="J10"></td>  
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <td id="I11"></td>  
                                        <td id="J11"></td>  
                                    </tr>
                                    <tr>
                                        <th>Head</th>
                                        <td id="I12"></td>  
                                        <td id="J12"></td>
                                    </tr>                                        
                                
                                    <!--Leech-->
                                    
                                    <tr>
                                        <th rowspan="3">Leech</th>
                                        <th>Head</th>
                                        <td id="I13"></td>  
                                        <td id="J13"></td>
                                    </tr>
                                    <tr>
                                        <th>SLE Half</th>
                                        <td id="I14"></td>  
                                        <td id="J14"></td>
                                    </tr>
                                    <tr>
                                        <th>Clew</th>
                                        <td id="I15"></td>  
                                        <td id="J15"></td>
                                    </tr>
                                

                                    <!--Foot-->
                                    <tr>
                                        <th rowspan="3">Foot</th>
                                        <th>Clew</th>
                                        <td id="I16"></td>  
                                        <td id="J16"></td>
                                    </tr>
                                    <tr>
                                        <th>Mid</th>
                                        <td id="I17"></td>  
                                        <td id="J17"></td>
                                    </tr>
                                    <tr>
                                        <th>Tack</th>
                                        <td id="I18">0</td>  
                                        <td id="J18">0</td>
                                    </tr>
                                    <tr><th colspan="4"></th></tr>
                                    <tr>
                                        <th colspan="2"></th>
                                        <th>x</th>
                                        <th>y</th>
                                    </tr>
                                
                                    <!--SLU-->
                                    <tr>
                                        <th rowspan="2">SLU</th>
                                        <th>Tack</th>
                                        <td id="I20">0</td>  
                                        <td id="J20">0</td>
                                    </tr>
                                    <tr>
                                        <th>Head</th>
                                        <td id="I21">0</td>  
                                        <td id="J21">0</td>
                                    </tr>
                                    <!--SLE-->
                                    <tr>
                                        <th rowspan="2">SLE</th>
                                        <th>Clew</th>
                                        <td id="I22">0</td>  
                                        <td id="J22">0</td>
                                    </tr>
                                    <tr>
                                        <th>Head</th>
                                        <td id="I23">0</td>  
                                        <td id="J23">0</td>
                                    </tr>

                                    <!--SHW-->
                                    <tr>
                                        <th rowspan="2">SHW</th>
                                        <th>SLU Half</th>
                                        <td id="SLU_Half_Luff_a_x"></td>
                                        <td id="SLU_Half_Luff_a_y"></td>
                                    </tr>
                                    <tr>
                                        <th>SLE Half</th>
                                        <td id="SLE_Half_Luff_x"></td>
                                        <td id="SLE_Half_Luff_y"></td>
                                    </tr>

                                    <!--SF-->
                                    <tr>
                                        <th rowspan="2">SF</th>
                                        <th>Tack</th>
                                        <td id="I26">0</td>  
                                        <td id="J26">0</td>
                                    </tr>
                                    <tr>
                                        <th>Clew</th>
                                        <td id="I27">0</td>  
                                        <td id="J27">0</td>
                                    </tr>
                                </tbody>    
                            </table>
                        </div><!--table_left-->

                        <div class="tablecont_right">
                            <table>
                                <thead>
                                    <tr>
                                        <th colspan="3">Data</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th>x</th>
                                        <th>y</th>
                                    </tr>
                                </thead>
                                <tbody>    
                                    <tr>
                                        <th>Max</th>
                                        <td id="AS_data_maxx"></td>
                                        <td id="AS_data_maxy"></td>
                                    </tr>
                                    <tr>
                                        <th>Min</th>
                                        <td id="AS_data_minx"></td>
                                        <td id="AS_data_miny"></td>
                                    </tr>
                                    <tr>
                                        <th>Range</th>
                                        <td id="AS_xdata_range"></td>
                                        <td id="AS_ydata_range"></td>
                                    </tr>
                                </tbody>    
                            </table>

                            <table>
                                <thead>
                                    <tr>
                                        <th colspan="3">Axes</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th>x</th>
                                        <th>y</th>
                                    </tr>
                                </thead>  
                                <tbody>  
                                    <tr>
                                        <th>Max</th>
                                        <td id="AS_axes_maxx"></td>
                                        <td id="AS_axes_maxy"></td>
                                    </tr>
                                    <tr>
                                        <th>Min</th>
                                        <td id="AS_axes_minx"></td>
                                        <td id="AS_axes_miny"></td>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <td id="M13"></td>
                                        <td id="N13"></td>
                                    </tr>
                                </tbody>    
                            </table>

                            <table>
                                <thead>
                                    <tr>
                                        <th colspan="3">Dummy Series</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th>x</th>
                                        <th>y</th>
                                    </tr>
                                </thead>
                                <tbody>    
                                    <tr>
                                        <th rowspan="2">Hor</th>
                                        <td id="AS_dummy_hor_maxx"></td>
                                        <td id="AS_dummy_hor_maxy"></td>
                                    </tr>
                                    <tr>
                                        <td id="AS_dummy_hor_minx"></td>
                                        <td id="AS_dummy_hor_miny"></td>
                                    </tr>
                                    <tr>
                                        <th rowspan="2">Vert</th>
                                        <td id="AS_dummy_vert_maxx"></td>
                                        <td id="AS_dummy_vert_maxy"></td>
                                    </tr>
                                    <tr>
                                        <td id="AS_dummy_vert_minx"></td>
                                        <td id="AS_dummy_vert_miny"></td>
                                    </tr>
                                </tbody>    
                            </table>


                        </div> <!--table_right-->   

                    </div><!--asym spinnaker-cont-->
                </div><!--asym spinnaker-->
                

                <div class="labels_cont">
                    <table>
                        <thead>
                            <tr>
                                <th>Labels</th>
                                <th></th>
                                <th>x</th>
                                <th>y</th>
                            </tr>
                        </thead>
                        <!--Luff length-->
                        <tbody>
                            <tr>
                                <th rowspan="4" id="G32"></th>
                                <th>Angle rad</th>
                                <td id="I32"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Angle deg</th>
                                <td id="I33"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th></th>
                                <td id="SLU_Label_mid_x"></td>
                                <td id="SLU_Label_mid_y"></td>
                            </tr>
                            <tr>
                                <th>Percent</th>
                                <td id="I35"></td>
                                <td></td>
                            </tr>
                            <tr><th colspan="4">&nbsp;</th></tr>
                            <!--Leech Lenght-->
                            <tr>
                                <th rowspan="4" id="G37"></th>
                                <th>Angle rad</th>
                                <td id="I37"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Angle deg</th>
                                <td id="I38"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th></th>
                                <td id="I39"></td>
                                <td id="J39"></td>
                            </tr>
                            <tr>
                                <th>Percent</th>
                                <td id="I40"></td>
                                <td></td>
                            </tr>

                            <tr><th colspan="4">&nbsp;</th></tr>
                            <!--Half width-->
                            <tr>
                                <th rowspan="4" id="G42"></th>
                                <th>Angle rad</th>
                                <td id="I42"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Angle deg</th>
                                <td id="I43"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Mid</th>
                                <td id="SHW_mid_x"></td>
                                <td id="SHW_mid_y"></td>
                            </tr>
                            <tr>
                                <th>Percent</th>
                                <td id="I45"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>Offset</th>
                                <td id="I46"></td>
                                <td id="J46"></td>
                            </tr>
                            
                            <tr><th colspan="4">&nbsp;</th></tr>
                            <!--Foot Length-->
                            <tr>
                                <th rowspan="3" id="G48"></th>
                                <th>Mid</th>
                                <td id="I48"></td>
                                <td id="J48"></td>
                            </tr>
                            <tr>
                                <th>Percent</th>
                                <td id="I49"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Offset</th>
                                <td id="I50"></td>
                                <td id="J50"></td>
                            </tr>
                            
                            <tr><th colspan="4">&nbsp;</th></tr>
                            <!--tick-->
                            <tr>
                                <th>Tick Offset</th>
                                <th></th>
                                <td id="Tick_Offset">0</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Tick Length</th>
                                <th></th>
                                <td id="Tick_Length">0</td>
                                <td></td>
                            </tr>

                            <tr><th colspan="4">&nbsp;</th></tr>
                            <!--Luff Tick-->
                            <tr>
                                <th></th>
                                <th></th>
                                <th>x</th>
                                <th>y</th>
                            </tr>
                            <tr>
                                <th rowspan="6">Luff Tick</th>
                                <th>Top Tick Left</th>
                                <td id="I55">0</td>
                                <td id="J55">0</td>
                            </tr>
                            <tr>
                                <th>Top Tick Right</th>
                                <td id="I56">0</td>
                                <td id="J56">0</td>
                            </tr>
                            <tr>
                                <th>Bot Tick Left</th>
                                <td id="I57">0</td>
                                <td id="J57">0</td>
                            </tr>
                            <tr>
                                <th>Bot Tick Right</th>
                                <td id="I58">0</td>
                                <td id="J58">0</td>
                            </tr>
                            <tr>
                                <th>Luff Dim Top</th>
                                <td id="I59">0</td>
                                <td id="J59">0</td>
                            </tr>
                            <tr>
                                <th>Luff Dim Bot</th>
                                <td id="I60">0</td>
                                <td id="J60">0</td>
                            </tr>
                            
                            <tr><th colspan="4">&nbsp;</th></tr>
                            <!--Leech Tick-->
                            <tr>
                                <th rowspan="6">Leech Tick</th>
                                <th>Top Tick Right</th>
                                <td id="I62">0</td>
                                <td id="J62">0</td>
                            </tr>
                            <tr>
                                <th>Top Tick Left</th>
                                <td id="I63">0</td>
                                <td id="J63">0</td>
                            </tr>
                            <tr>
                                <th>Bot Tick Right</th>
                                <td id="I64">0</td>
                                <td id="J64">0</td>
                            </tr>
                            <tr>
                                <th>Bot Tick Left</th>
                                <td id="I65">0</td>
                                <td id="J65">0</td>
                            </tr>
                            <tr>
                                <th>Leech Dim Top</th>
                                <td id="I66">0</td>
                                <td id="J66">0</td>
                            </tr>
                            <tr>
                                <th>Leech Dim Bot</th>
                                <td id="I67">0</td>
                                <td id="J67">0</td>
                            </tr>

                            <tr><th colspan="4">&nbsp;</th></tr>
                            <!--Foot Tick-->
                            <tr>
                                <th rowspan="6">Foot Tick</th>
                                <th>Left Tick Top</th>
                                <td id="I69">0</td>
                                <td id="J69">0</td>
                            </tr>
                            <tr>
                                <th>Left Tick Bot</th>
                                <td id="I70">0</td>
                                <td id="J70">0</td>
                            </tr>
                            <tr>
                                <th>Right Tick Top</th>
                                <td id="I71">0</td>
                                <td id="J71">0</td>
                            </tr>
                            <tr>
                                <th>Right Tick Bot</th>
                                <td id="I72">0</td>
                                <td id="J72">0</td>
                            </tr>
                            <tr>
                                <th>Foot Dim Left</th>
                                <td id="I73">0</td>
                                <td id="J73">0</td>
                            </tr>
                            <tr>
                                <th>Foot Dim Right</th>
                                <td id="I74">0</td>
                                <td id="J74">0</td>
                            </tr>
                        </tbody>    
                    </table>
                </div><!--labels-cont-->
            </div><!--panel-left-2-->    
        </div><!--panel-left-->

        <div class="panel-right">
            <h2>Asym spinnaker</h2>

            <div id="asym-1_calcs_cont">
                <div class="tablecont_left">
                
                    <table>
                        <tr>
                            <th>Assumed Spin Tack to Mast Angle</th>
                            <td id="Assumed_Tack_Angle_d">69.0</td>
                            <td>Deg</td>
                        </tr>
                        <tr>
                            <th>Assumed Tack x</th>
                            <td id="Tack_a_x">0</td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Assumed Tack y</th>
                            <td id="Tack_a_y">0</td>
                            <td></td>
                        </tr>
                        

                        <tr><th colspan="3">&nbsp;</th></tr>
                        <tr>
                            <th>Tack Angle Plus</th>
                            <td id="TAP_d"></td>
                            <td>Deg</td>
                        </tr>
                        <tr>
                            <th>Tack Angle Plus</th>
                            <td id="TAP_r"></td>
                            <td>Rad</td>
                        </tr>
                        <tr>
                            <th>Tack Angle</th>
                            <td id="Tack_Angle_a_r"></td>
                            <td>Rad</td>
                        </tr>
                        <tr>
                            <th>Tack Angle</th>
                            <td id="Tack_Angle_a_d"></td>
                            <td>Deg</td>
                        </tr>
                        <tr>
                            <th>Head Angle</th>
                            <td id="Head_Angle_a_r"></td>
                            <td>Rad</td>
                        </tr>
                        <tr>
                            <th>Head Angle</th>
                            <td id="Head_Angle_a_d"></td>
                            <td>Deg</td>
                        </tr>
                        <tr>
                            <th>Clew Angle</th>
                            <td id="R14">0</td>
                            <td>Rad</td>
                        </tr>
                        <tr>
                            <th>Clew Angle</th>
                            <td id="Clew_Angle_a_d"></td>
                            <td>Deg</td>
                        </tr>
                        <tr>
                            <th>Clew Height Angle</th>
                            <td id="Clew_Height_Angle_r"></td>
                            <td>Rad</td>
                        </tr>
                        <tr>
                            <th>Clew Height Angle</th>
                            <td id="Clew_Height_Angle_d"></td>
                            <td>Deg</td>
                        </tr>
                        <tr>
                            <th>Ext SLE Angle</th>
                            <td id="Ext_SLE_Angle_r"></td>
                            <td>Rad</td>
                        </tr>
                        <tr>
                            <th>Ext SLE Angle</th>
                            <td id="Ext_SLE_Angle_d"></td>
                            <td>Deg</td>
                        </tr>
                        <tr>
                            <th>Radians(90)</th>
                            <td id="Radians_90">1.57</td>
                            <td>Red</td>
                        </tr>

                        <tr><th colspan="3">&nbsp;</th></tr>                    
                        <tr>
                            <th>Mid Foot x,y</th>
                            <td id="Mid_Foot_x"></td>
                            <td id="Mid_Foot_y"></td>
                        </tr>
                        <tr>
                            <th>Foot Offset Factor</th>
                            <td id="Foot_Offset_Factor">0.04</td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Foot Offset Distance</th>
                            <td id="Foot_Offset_Distance">0</td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Foot Offset x,y</th>
                            <td id="Foot_Offset_x"></td>
                            <td id="Foot_Offset_y"></td>
                        </tr>

                        <tr><th colspan="3">&nbsp;</th></tr>
                        <tr>
                            <th>SLU Offset to Half Luff Factor</th>
                            <td id="SLU_Offset_to_Half_Leech_Factor"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>SLU Offset to Half Luff Length</th>
                            <td id="SLU_Offset_Length"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>SLU Mid</th>
                            <td id="SLU_Mid_x"></td>
                            <td id="SLU_Mid_y"></td>
                        </tr>
                        <tr>
                            <th>SLU Half Luff Point</th>
                            <td id="SLU_Half_Leech_Point_x"></td>
                            <td id="SLU_Half_Leech_Point_y"></td>
                        </tr>
                        
                        <tr><th colspan="3">&nbsp;</th></tr>
                        <tr>
                            <th>SLE Mid Ext Factor</th>
                            <td id="SLE_Mid_Ext_Factor"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>SLE Mid Ext Distance</th>
                            <td id="SLE_Mid_Ext_Distance">0</td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>SLE Mid Luff Angle</th>
                            <td id="SLE_Mid_Luff_Angle"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>SLE Mid Ext x,y</th>
                            <td id="SLE_Mid_Ext_x"></td>
                            <td id="SLE_Mid_Ext_y"></td>
                        </tr>
                        <tr>
                            <th>SLE Mid</th>
                            <td id="SLE_Mid_x"></td>
                            <td id="SLE_Mid_y"></td>
                        </tr>
                        
                        <tr><th colspan="3">&nbsp;</th></tr>
                        <tr>
                            <th>Lookup Intercept</th>
                            <td id="SHW_Intercept_x"></td>
                            <td id="SHW_Intercept_y"></td>
                        </tr>
                        
                        <tr><th colspan="3">&nbsp;</th></tr>
                        <tr>
                            <th>AMG / SHW</th>
                            <td id="R40">0</td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Distance at VLOOKUP</th>
                            <td id="R41"></td>
                            <td></td>
                        </tr>
                        
                        <tr><th colspan="3">&nbsp;</th></tr>
                        <tr>
                            <th>Tack Angle + 90</th>
                            <td id="TAPer"></td>
                            <td>Rad</td>
                        </tr>
                        <tr>
                            <th>Tack Angle + 90</th>
                            <td id="R46"></td>
                            <td>Deg</td>
                        </tr>
                        
                        <tr><th colspan="3">&nbsp;</th></tr>
                        <tr>
                            <th>Leech Angle - 90</th>
                            <td id="LAPer"></td>
                            <td>Rad</td>
                        </tr>
                        <tr>
                            <th>Leech Angle - 90</th>
                            <td id="R49"></td>
                            <td>Deg</td>
                        </tr>
                        
                        <tr><th colspan="3">&nbsp;</th></tr>
                        <tr>
                            <th>Foot Angle - 90</th>
                            <td id="FAPer"></td>
                            <td>Rad</td>
                        </tr>
                        <tr>
                            <th>Foot Angle - 90</th>
                            <td id="R52"></td>
                            <td>Deg</td>
                        </tr>                   
                    </table>
                </div>
                <div class="tablecont_right">
                    <table>
                        <tr>
                            <th>SLE Mid</th>
                            <td id="V4"></td>
                            <td id="W4"></td>
                        </tr>
                        <tr>
                            <th>Offset Distance</th>
                            <td id="V5"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>0.5*Offset</th>
                            <td id="V6"></td>
                            <td id="W6">0.75</td>
                        </tr>
                        <tr>
                            <th>1.5*Offset</th>
                            <td id="V7"></td>
                            <td id="W7">1.25</td>
                        </tr>
                    </table>
                    <table>
                        <tbody>
                            <tr>
                                <th>Step inc</th>
                                <td>0.01</td>
                            </tr>
                        </tbody>
                    </table>

                    <table id="500val">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Dist</th>
                                <th>x</th>
                                <th>y</th>
                            </tr>
                        </thead>
                        <tbody>    
                            <tr>
                                <th>Start</th>
                                <td id="V12"></td>
                                <td id="Start_for_int_x">0</td>
                                <td id="Start_for_int_y">0</td>
                            </tr>
                        </tbody>
                    </table>

                </div><!--tablecont_right-->

            </div><!--asym-1_calcs_cont-->
        </div>
    </div><!--calc_container-->

	
</body>

</html>