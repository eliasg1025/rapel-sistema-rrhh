@extends('layout')

@section('titulo')
    FICHA PERSONAL contrato declaracion topico - Obrero de Campo
@endsection

@section('contenido')

<style>
    body {margin-top: 0px;margin-left: 0px;}
    #page_5 #p5dimg1 {position:absolute;top:353px;left:20px;z-index:-1;width:238px;height:556px;}
    #page_5 #p5dimg1 #p5img1 {width:238px;height:556px;}


    #page_7 #p7dimg1 {position:absolute;top:0px;left:11px;z-index:-1;width:93px;height:40px;}
    #page_7 #p7dimg1 #p7img1 {width:93px;height:40px;}
    #page_9 #p9dimg1 {position:absolute;top:0px;left:71px;z-index:-1;width:641px;height:823px;}
    #page_9 #p9dimg1 #p9img1 {width:641px;height:823px;}

    #page_11 #p11dimg1 {position:absolute;top:676px;left:31px;z-index:-1;width:239px;height:130px;}
    #page_11 #p11dimg1 #p11img1 {width:239px;height:130px;}



    #page_13 #p13dimg1 {position:absolute;top:101px;left:57px;z-index:-1;width:456px;height:610px;}
    #page_13 #p13dimg1 #p13img1 {width:456px;height:610px;}





    #page_15 #id15_1 {float:left;border:none;margin: 19px 0px 0px 0px;padding: 0px;border:none;width: 594px;overflow: hidden;}
    #page_15 #id15_2 {float:left;border:none;margin: 20px 0px 0px 0px;padding: 0px;border:none;width: 529px;overflow: hidden;}

    #page_15 #p15dimg1 {position:absolute;top:0px;left:39px;z-index:-1;width:994px;height:614px;}
    #page_15 #p15dimg1 #p15img1 {width:994px;height:614px;}






    #page_17 #id17_1 {float:left;border:none;margin: 23px 0px 0px 7px;padding: 0px;border:none;width: 546px;overflow: hidden;}
    #page_17 #id17_2 {float:left;border:none;margin: 24px 0px 0px 0px;padding: 0px;border:none;width: 541px;overflow: hidden;}

    #page_17 #p17dimg1 {position:absolute;top:0px;left:0px;z-index:-1;width:1017px;height:557px;}
    #page_17 #p17dimg1 #p17img1 {width:1017px;height:557px;}



    #page_19 #p19dimg1 {position:absolute;top:0px;left:35px;z-index:-1;width:660px;height:78px;}
    #page_19 #p19dimg1 #p19img1 {width:660px;height:78px;}



    #page_21 #p21dimg1 {position:absolute;top:0px;left:0px;z-index:-1;width:722px;height:1039px;}
    #page_21 #p21dimg1 #p21img1 {width:722px;height:1039px;}

    #page_23 #id23_1 {border:none;margin: 18px 0px 0px 23px;padding: 0px;border:none;width: 711px;overflow: hidden;}
    #page_23 #id23_2 {border:none;margin: 18px 0px 0px 19px;padding: 0px;border:none;width: 715px;overflow: hidden;}
    #page_23 #id23_2 #id23_2_1 {float:left;border:none;margin: 0px 0px 0px 0px;padding: 0px;border:none;width: 441px;overflow: hidden;}
    #page_23 #id23_2 #id23_2_2 {float:left;border:none;margin: 24px 0px 0px 0px;padding: 0px;border:none;width: 274px;overflow: hidden;}
    #page_23 #id23_3 {border:none;margin: 18px 0px 0px 19px;padding: 0px;border:none;width: 715px;overflow: hidden;}

    #page_23 #p23dimg1 {position:absolute;top:0px;left:0px;z-index:-1;width:702px;height:1025px;}
    #page_23 #p23dimg1 #p23img1 {width:702px;height:1025px;}


    #page_25 #id25_1 {float:left;border:none;margin: 7px 0px 0px 0px;padding: 0px;border:none;width: 593px;overflow: hidden;}
    #page_25 #id25_2 {float:left;border:none;margin: 18px 0px 0px 0px;padding: 0px;border:none;width: 509px;overflow: hidden;}

    #page_25 #p25dimg1 #p25img1 {width:1032px;height:678px;}

    #page_27 #id27_1 {border:none;margin: 0px 0px 0px 0px;padding: 0px;border:none;width: 557px;overflow: hidden;}
    #page_27 #id27_2 {border:none;margin: 0px 0px 0px 87px;padding: 0px;border:none;width: 470px;overflow: hidden;}





    #page_29 #p29dimg1 {position:absolute;top:0px;left:0px;z-index:-1;width:794px;height:918px;}
    #page_29 #p29dimg1 #p29img1 {width:794px;height:918px;}




    .dclr {clear:both;float:none;height:1px;margin:0px;padding:0px;overflow:hidden;}

    .ft0{font: 13px 'Courier New';line-height: 16px;}
    .ft1{font: bold 12px 'Calibri Light';text-decoration: underline;line-height: 14px;}
    .ft2{font: 12px 'Calibri Light';line-height: 14px;}
    .ft3{font: bold 12px 'Calibri Light';line-height: 14px;}
    .ft4{font: 12px 'Wingdings';line-height: 14px;}
    .ft5{font: bold 12px 'Calibri Light';margin-left: 9px;line-height: 14px;}
    .ft6{font: italic bold 12px 'Calibri Light';margin-left: 9px;line-height: 14px;}
    .ft7{font: bold 12px 'Calibri Light';margin-left: 14px;line-height: 14px;}
    .ft8{font: 12px 'Calibri Light';margin-left: 14px;line-height: 14px;}
    .ft9{font: 11px 'Calibri Light';line-height: 13px;}
    .ft10{font: 11px 'Calibri Light';margin-left: 14px;line-height: 13px;}
    .ft11{font: bold 11px 'Calibri Light';line-height: 13px;}
    .ft12{font: 12px 'Century Gothic';line-height: 17px;}
    .ft13{font: 12px 'Calibri Light';margin-left: 22px;line-height: 14px;}
    .ft14{font: 12px 'Calibri Light';margin-left: 19px;line-height: 14px;}
    .ft15{font: 12px 'Calibri Light';margin-left: 5px;line-height: 14px;}
    .ft16{font: bold 11px 'Calibri Light';margin-left: 14px;line-height: 13px;}
    .ft17{font: bold 12px 'Calibri Light';margin-left: 8px;line-height: 14px;}
    .ft18{font: 12px 'Calibri Light';margin-left: 8px;line-height: 14px;}
    .ft19{font: bold 11px 'Calibri Light';margin-left: 8px;line-height: 14px;}
    .ft20{font: bold 11px 'Calibri Light';line-height: 14px;}
    .ft21{font: italic bold 11px 'Calibri Light';text-decoration: underline;line-height: 14px;}
    .ft22{font: italic bold 11px 'Calibri Light';line-height: 14px;}
    .ft23{font: 11px 'Calibri Light';line-height: 14px;}
    .ft24{font: bold 11px 'Calibri Light';margin-left: 8px;line-height: 13px;}
    .ft25{font: bold 12px 'Calibri Light';text-decoration: underline;margin-left: 8px;line-height: 14px;}
    .ft26{font: 12px 'Calibri Light';text-decoration: underline;line-height: 14px;}
    .ft27{font: italic bold 12px 'Calibri Light';line-height: 14px;}
    .ft28{font: bold 19px 'Arial';text-decoration: underline;line-height: 22px;}
    .ft29{font: bold 15px 'Arial';line-height: 17px;}
    .ft30{font: 15px 'Arial';line-height: 17px;}
    .ft31{font: bold 16px 'Arial Narrow';line-height: 20px;}
    .ft32{font: 1px 'Arial Narrow';line-height: 1px;}
    .ft33{font: bold 16px 'Arial Narrow';line-height: 17px;}
    .ft34{font: 16px 'Arial Narrow';line-height: 17px;}
    .ft35{font: 16px 'Arial Narrow';line-height: 19px;}
    .ft36{font: 16px 'Arial Narrow';line-height: 18px;}
    .ft37{font: 15px 'Arial Narrow';line-height: 19px;}
    .ft38{font: bold 15px 'Arial';line-height: 18px;}
    .ft39{font: bold 16px 'Arial';line-height: 19px;}
    .ft40{font: 8px 'Tahoma';line-height: 10px;}
    .ft41{font: bold 11px 'Tahoma';line-height: 13px;}
    .ft42{font: 11px 'Tahoma';line-height: 13px;}
    .ft43{font: 11px 'Tahoma';line-height: 12px;}
    .ft44{font: 12px 'Tahoma';line-height: 14px;}
    .ft45{font: bold 12px 'Tahoma';line-height: 14px;}
    .ft46{font: bold 9px 'Tahoma';line-height: 11px;}
    .ft47{font: bold 15px 'Tahoma';line-height: 18px;}
    .ft48{font: bold 13px 'Tahoma';line-height: 16px;}
    .ft49{font: 13px 'Tahoma';line-height: 16px;}
    .ft50{font: 13px 'Tahoma';line-height: 23px;}
    .ft51{font: bold 13px 'Tahoma';line-height: 23px;}
    .ft52{font: italic bold 13px 'Tahoma';line-height: 16px;}
    .ft53{font: 13px 'Tahoma';margin-left: 16px;line-height: 16px;}
    .ft54{font: 1px 'Tahoma';line-height: 4px;}
    .ft55{font: bold 13px 'Tahoma';text-decoration: underline;line-height: 16px;}
    .ft56{font: 13px 'Tahoma';margin-left: 5px;line-height: 16px;}
    .ft57{font: italic 13px 'Tahoma';line-height: 16px;}
    .ft58{font: bold 16px 'Tahoma';line-height: 19px;}
    .ft59{font: 1px 'Tahoma';line-height: 1px;}
    .ft60{font: italic 12px 'Times New Roman';line-height: 15px;}
    .ft61{font: 8px 'Calibri';line-height: 10px;}
    .ft62{font: bold 12px 'Times New Roman';line-height: 15px;}
    .ft63{font: 11px 'Tahoma';line-height: 14px;}
    .ft64{font: bold 16px 'Times New Roman';line-height: 19px;}
    .ft65{font: 11px 'Tahoma';margin-left: 9px;line-height: 13px;}
    .ft66{font: 11px 'Tahoma';margin-left: 9px;line-height: 15px;}
    .ft67{font: 11px 'Tahoma';line-height: 15px;}
    .ft68{font: bold 11px 'Arial';line-height: 14px;}
    .ft69{font: 11px 'Arial';line-height: 13px;}
    .ft70{font: 11px 'Arial';line-height: 14px;}
    .ft71{font: 11px 'Arial';margin-left: 19px;line-height: 14px;}
    .ft72{font: 11px 'Arial';margin-left: 19px;line-height: 13px;}
    .ft73{font: 1px 'Tahoma';line-height: 6px;}
    .ft74{font: 1px 'Tahoma';line-height: 8px;}
    .ft75{font: 1px 'Tahoma';line-height: 5px;}
    .ft76{font: 1px 'Tahoma';line-height: 2px;}
    .ft77{font: 9px 'Arial';line-height: 12px;}
    .ft78{font: bold 9px 'Arial';line-height: 11px;}
    .ft79{font: 8px 'Tahoma';margin-left: 12px;line-height: 10px;}
    .ft80{font: bold 8px 'Tahoma';line-height: 10px;}
    .ft81{font: bold 8px 'Arial';line-height: 10px;}
    .ft82{font: 8px 'Tahoma';margin-left: 20px;line-height: 10px;}
    .ft83{font: 1px 'Tahoma';line-height: 7px;}
    .ft84{font: 10px 'Tahoma';line-height: 12px;}
    .ft85{font: 16px 'Times New Roman';line-height: 19px;}
    .ft86{font: bold 16px 'Times New Roman';text-decoration: underline;line-height: 19px;}
    .ft87{font: 15px 'Times New Roman';line-height: 17px;}
    .ft88{font: bold 15px 'Times New Roman';line-height: 17px;}
    .ft89{font: 13px 'Times New Roman';line-height: 15px;}
    .ft90{font: 15px 'Times New Roman';margin-left: 17px;line-height: 17px;}
    .ft91{font: 15px 'Times New Roman';line-height: 15px;}
    .ft92{font: bold 15px 'Times New Roman';margin-left: 17px;line-height: 15px;}
    .ft93{font: bold 15px 'Times New Roman';line-height: 15px;}
    .ft94{font: 15px 'Times New Roman';line-height: 14px;}
    .ft95{font: 15px 'Times New Roman';margin-left: 17px;line-height: 14px;}
    .ft96{font: 15px 'Times New Roman';margin-left: 16px;line-height: 17px;}
    .ft97{font: 15px 'Times New Roman';margin-left: 17px;line-height: 15px;}
    .ft98{font: 15px 'Times New Roman';margin-left: 16px;line-height: 15px;}
    .ft99{font: 15px 'Times New Roman';line-height: 16px;}
    .ft100{font: 15px 'Times New Roman';margin-left: 16px;line-height: 16px;}
    .ft101{font: bold 15px 'Times New Roman';line-height: 16px;}
    .ft102{font: bold 13px 'Times New Roman';margin-left: 17px;line-height: 15px;}
    .ft103{font: bold 13px 'Times New Roman';line-height: 15px;}
    .ft104{font: 1px 'Times New Roman';line-height: 1px;}
    .ft105{font: 1px 'Times New Roman';line-height: 3px;}
    .ft106{font: 1px 'Times New Roman';line-height: 6px;}
    .ft107{font: 1px 'Times New Roman';line-height: 5px;}
    .ft108{font: 1px 'Times New Roman';line-height: 7px;}
    .ft109{font: bold 20px 'Tahoma';text-decoration: underline;line-height: 24px;}
    .ft110{font: bold 14px 'Tahoma';line-height: 17px;}
    .ft111{font: 1px 'Tahoma';line-height: 15px;}
    .ft112{font: 13px 'Tahoma';line-height: 15px;}
    .ft113{font: 1px 'Tahoma';line-height: 9px;}
    .ft114{font: 1px 'Tahoma';line-height: 14px;}
    .ft115{font: bold 15px 'Tahoma';line-height: 17px;}
    .ft116{font: bold 16px 'Tahoma';text-decoration: underline;line-height: 19px;}
    .ft117{font: bold 13px 'Tahoma';text-decoration: underline;margin-left: 16px;line-height: 16px;}
    .ft118{font: 1px 'Tahoma';line-height: 10px;}
    .ft119{font: bold 13px 'Tahoma';text-decoration: underline;margin-left: 12px;line-height: 16px;}
    .ft120{font: bold 13px 'Tahoma';text-decoration: underline;margin-left: 9px;line-height: 16px;}
    .ft121{font: 13px 'Tahoma';line-height: 16px;position: relative; bottom: -7px;}
    .ft122{font: 13px 'Tahoma';line-height: 17px;}
    .ft123{font: 13px 'Tahoma';margin-left: 4px;line-height: 16px;}
    .ft124{font: 1px 'Tahoma';line-height: 13px;}
    .ft125{font: 1px 'Tahoma';line-height: 12px;}
    .ft126{font: 13px 'Tahoma';margin-left: 18px;line-height: 16px;}
    .ft127{font: bold 12px 'Tahoma';margin-left: 4px;line-height: 14px;}
    .ft128{font: 12px 'Times New Roman';line-height: 15px;}
    .ft129{font: 12px 'Tahoma';margin-left: 4px;line-height: 14px;}
    .ft130{font: 12px 'Tahoma';margin-left: 3px;line-height: 14px;}
    .ft131{font: 13px 'Tahoma';margin-left: 3px;line-height: 16px;}
    .ft132{font: bold 11px 'Tahoma';color: #0d0d0d;line-height: 13px;}
    .ft133{font: bold 12px 'Tahoma';color: #0d0d0d;margin-left: 4px;line-height: 14px;}
    .ft134{font: bold 12px 'Tahoma';color: #0d0d0d;line-height: 14px;}
    .ft135{font: bold 13px 'Tahoma';margin-left: 4px;line-height: 16px;}
    .ft136{font: 13px 'Times New Roman';line-height: 21px;}
    .ft137{font: 13px 'Tahoma';line-height: 22px;}
    .ft138{font: bold 13px 'Arial';line-height: 15px;}
    .ft139{font: bold 13px 'Arial';line-height: 16px;}
    .ft140{font: 1px 'Calibri Light';line-height: 1px;}
    .ft141{font: bold 15px 'Calibri Light';line-height: 18px;}
    .ft142{font: 15px 'Calibri Light';line-height: 18px;}
    .ft143{font: bold 15px 'Calibri Light';text-decoration: underline;line-height: 19px;}
    .ft144{font: 15px 'Calibri Light';line-height: 19px;}
    .ft145{font: bold 15px 'Calibri Light';text-decoration: underline;line-height: 18px;}
    .ft146{font: 16px 'Calibri Light';line-height: 19px;}
    .ft147{font: bold 16px 'Calibri Light';line-height: 19px;}
    .ft148{font: bold 16px 'Calibri Light';background-color: #c0c0c0;line-height: 19px;}
    .ft149{font: bold 15px 'Calibri Light';background-color: #c0c0c0;line-height: 18px;}
    .ft150{font: bold 16px 'Calibri Light';line-height: 21px;}
    .ft151{font: 16px 'Calibri Light';text-decoration: underline;line-height: 21px;}
    .ft152{font: 16px 'Calibri Light';line-height: 21px;}

    .p0{text-align: left;padding-left: 572px;margin-top: 0px;margin-bottom: 0px;}
    .p1{text-align: left;padding-left: 200px;margin-top: 1px;margin-bottom: 0px;}
    .p2{text-align: justify;padding-right: 47px;margin-top: 15px;margin-bottom: 0px;}
    .p3{text-align: justify;padding-left: 19px;padding-right: 47px;margin-top: 15px;margin-bottom: 0px;text-indent: -19px;}
    .p4{text-align: justify;padding-left: 19px;padding-right: 47px;margin-top: 16px;margin-bottom: 0px;text-indent: -19px;}
    .p5{text-align: left;margin-top: 19px;margin-bottom: 0px;}
    .p6{text-align: left;margin-top: 0px;margin-bottom: 0px;}
    .p7{text-align: left;padding-left: 29px;padding-right: 48px;margin-top: 1px;margin-bottom: 0px;text-indent: -29px;}
    .p8{text-align: left;padding-left: 29px;padding-right: 47px;margin-top: 1px;margin-bottom: 0px;text-indent: -29px;}
    .p9{text-align: justify;padding-left: 29px;padding-right: 47px;margin-top: 1px;margin-bottom: 0px;text-indent: -29px;}
    .p10{text-align: left;margin-top: 17px;margin-bottom: 0px;}
    .p11{text-align: left;padding-left: 29px;margin-top: 1px;margin-bottom: 0px;}
    .p12{text-align: justify;padding-left: 29px;padding-right: 43px;margin-top: 2px;margin-bottom: 0px;text-indent: -29px;}
    .p13{text-align: justify;padding-left: 29px;padding-right: 43px;margin-top: 1px;margin-bottom: 0px;text-indent: -29px;}
    .p14{text-align: left;padding-left: 29px;margin-top: 3px;margin-bottom: 0px;}
    .p15{text-align: left;margin-top: 1px;margin-bottom: 0px;}
    .p16{text-align: left;padding-left: 29px;margin-top: 13px;margin-bottom: 0px;}
    .p17{text-align: left;padding-left: 29px;margin-top: 0px;margin-bottom: 0px;}
    .p18{text-align: justify;padding-left: 29px;padding-right: 47px;margin-top: 3px;margin-bottom: 0px;text-indent: -29px;}
    .p19{text-align: left;margin-top: 10px;margin-bottom: 0px;}
    .p20{text-align: left;padding-left: 29px;padding-right: 47px;margin-top: 2px;margin-bottom: 0px;text-indent: -29px;}
    .p21{text-align: left;padding-left: 29px;padding-right: 47px;margin-top: 3px;margin-bottom: 0px;}
    .p22{text-align: left;padding-right: 47px;margin-top: 0px;margin-bottom: 0px;}
    .p23{text-align: left;margin-top: 16px;margin-bottom: 0px;}
    .p24{text-align: justify;padding-left: 29px;padding-right: 47px;margin-top: 2px;margin-bottom: 0px;text-indent: -29px;}
    .p25{text-align: left;padding-left: 29px;padding-right: 48px;margin-top: 2px;margin-bottom: 0px;text-indent: -29px;}
    .p26{text-align: left;padding-left: 29px;padding-right: 47px;margin-top: 0px;margin-bottom: 0px;text-indent: -29px;}
    .p27{text-align: left;padding-left: 29px;padding-right: 44px;margin-top: 2px;margin-bottom: 0px;text-indent: -29px;}
    .p28{text-align: justify;padding-left: 29px;padding-right: 47px;margin-top: 10px;margin-bottom: 0px;text-indent: -29px;}
    .p29{text-align: left;padding-left: 29px;padding-right: 47px;margin-top: 10px;margin-bottom: 0px;text-indent: -29px;}
    .p30{text-align: left;margin-top: 24px;margin-bottom: 0px;}
    .p31{text-align: left;padding-left: 29px;padding-right: 47px;margin-top: 1px;margin-bottom: 0px;}
    .p32{text-align: justify;padding-right: 43px;margin-top: 0px;margin-bottom: 0px;}
    .p33{text-align: left;margin-top: 4px;margin-bottom: 0px;}
    .p34{text-align: left;margin-top: 15px;margin-bottom: 0px;}
    .p35{text-align: justify;padding-right: 47px;margin-top: 1px;margin-bottom: 0px;}
    .p36{text-align: justify;padding-left: 29px;padding-right: 47px;margin-top: 1px;margin-bottom: 0px;text-indent: -27px;}
    .p37{text-align: left;padding-right: 57px;margin-top: 1px;margin-bottom: 0px;}
    .p38{text-align: justify;padding-left: 29px;padding-right: 47px;margin-top: 0px;margin-bottom: 0px;text-indent: -29px;}
    .p39{text-align: left;padding-left: 29px;padding-right: 48px;margin-top: 4px;margin-bottom: 0px;text-indent: -29px;}
    .p40{text-align: left;padding-left: 29px;padding-right: 43px;margin-top: 2px;margin-bottom: 0px;text-indent: -29px;}
    .p41{text-align: left;padding-left: 29px;padding-right: 48px;margin-top: 3px;margin-bottom: 0px;text-indent: -29px;}
    .p42{text-align: justify;padding-left: 29px;padding-right: 47px;margin-top: 17px;margin-bottom: 0px;text-indent: -29px;}
    .p43{text-align: left;padding-left: 29px;padding-right: 47px;margin-top: 2px;margin-bottom: 0px;}
    .p44{text-align: left;margin-top: 25px;margin-bottom: 0px;}
    .p45{text-align: right;padding-right: 100px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p46{text-align: right;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p47{text-align: right;padding-right: 148px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p48{text-align: right;padding-right: 29px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p49{text-align: left;padding-left: 304px;margin-top: 0px;margin-bottom: 0px;}
    .p50{text-align: justify;padding-right: 57px;margin-top: 14px;margin-bottom: 0px;}
    .p51{text-align: left;margin-top: 2px;margin-bottom: 0px;}
    .p52{text-align: justify;padding-right: 57px;margin-top: 34px;margin-bottom: 0px;}
    .p53{text-align: left;padding-left: 7px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p54{text-align: left;padding-left: 8px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p55{text-align: left;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p56{text-align: left;padding-left: 6px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p57{text-align: right;padding-right: 65px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p58{text-align: right;padding-right: 106px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p59{text-align: right;padding-right: 118px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p60{text-align: right;padding-right: 71px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p61{text-align: left;padding-left: 267px;margin-top: 19px;margin-bottom: 0px;}
    .p62{text-align: justify;padding-right: 57px;margin-top: 27px;margin-bottom: 0px;}
    .p63{text-align: justify;padding-right: 57px;margin-top: 0px;margin-bottom: 0px;}
    .p64{text-align: left;margin-top: 5px;margin-bottom: 0px;}
    .p65{text-align: justify;padding-right: 57px;margin-top: 1px;margin-bottom: 0px;}
    .p66{text-align: justify;padding-right: 57px;margin-top: 4px;margin-bottom: 0px;}
    .p67{text-align: left;margin-top: 64px;margin-bottom: 0px;}
    .p68{text-align: left;padding-left: 542px;margin-top: 15px;margin-bottom: 0px;}
    .p69{text-align: left;padding-left: 101px;margin-top: 17px;margin-bottom: 0px;}
    .p70{text-align: left;padding-left: 351px;margin-top: 0px;margin-bottom: 0px;}
    .p71{text-align: left;padding-left: 66px;margin-top: 61px;margin-bottom: 0px;}
    .p72{text-align: justify;padding-left: 66px;padding-right: 76px;margin-top: 5px;margin-bottom: 0px;}
    .p73{text-align: left;padding-left: 94px;margin-top: 56px;margin-bottom: 0px;}
    .p74{text-align: left;padding-left: 94px;margin-top: 8px;margin-bottom: 0px;}
    .p75{text-align: justify;padding-left: 66px;padding-right: 76px;margin-top: 32px;margin-bottom: 0px;}
    .p76{text-align: justify;padding-left: 66px;padding-right: 76px;margin-top: 28px;margin-bottom: 0px;text-indent: 4px;}
    .p77{text-align: left;padding-left: 66px;margin-top: 27px;margin-bottom: 0px;}
    .p78{text-align: right;padding-right: 57px;margin-top: 41px;margin-bottom: 0px;}
    .p79{text-align: left;padding-left: 11px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p80{text-align: center;padding-left: 15px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p81{text-align: center;padding-left: 17px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p82{text-align: left;padding-left: 51px;margin-top: 0px;margin-bottom: 0px;}
    .p83{text-align: justify;padding-right: 57px;margin-top: 16px;margin-bottom: 0px;}
    .p84{text-align: justify;padding-right: 57px;margin-top: 9px;margin-bottom: 0px;}
    .p85{text-align: justify;padding-right: 56px;margin-top: 10px;margin-bottom: 0px;}
    .p86{text-align: left;padding-right: 56px;margin-top: 0px;margin-bottom: 0px;}
    .p87{text-align: right;padding-right: 57px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p88{text-align: center;padding-right: 58px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p89{text-align: center;padding-left: 93px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p90{text-align: left;padding-left: 160px;margin-top: 0px;margin-bottom: 0px;}
    .p91{text-align: left;padding-left: 131px;margin-top: 0px;margin-bottom: 0px;}
    .p92{text-align: right;padding-right: 104px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p93{text-align: justify;padding-left: 45px;padding-right: 691px;margin-top: 0px;margin-bottom: 0px;}
    .p94{text-align: justify;padding-left: 45px;padding-right: 691px;margin-top: 14px;margin-bottom: 0px;text-indent: 3px;}
    .p95{text-align: right;padding-right: 647px;margin-top: 217px;margin-bottom: 0px;}
    .p96{text-align: right;padding-right: 61px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p97{text-align: right;padding-right: 143px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p98{text-align: left;padding-left: 26px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p99{text-align: right;padding-right: 111px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p100{text-align: right;padding-right: 74px;margin-top: 0px;margin-bottom: 0px;}
    .p101{text-align: left;padding-left: 47px;margin-top: 31px;margin-bottom: 0px;}
    .p102{text-align: left;padding-left: 208px;margin-top: 1px;margin-bottom: 0px;}
    .p103{text-align: justify;padding-left: 45px;padding-right: 93px;margin-top: 28px;margin-bottom: 0px;}
    .p104{text-align: justify;padding-left: 45px;padding-right: 92px;margin-top: 31px;margin-bottom: 0px;}
    .p105{text-align: justify;padding-left: 45px;padding-right: 93px;margin-top: 32px;margin-bottom: 0px;}
    .p106{text-align: left;padding-left: 45px;margin-top: 13px;margin-bottom: 0px;}
    .p107{text-align: left;padding-left: 45px;margin-top: 28px;margin-bottom: 0px;}
    .p108{text-align: right;padding-right: 26px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p109{text-align: left;padding-left: 27px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p110{text-align: left;padding-left: 181px;margin-top: 0px;margin-bottom: 0px;}
    .p111{text-align: left;padding-left: 62px;margin-top: 0px;margin-bottom: 0px;}
    .p112{text-align: left;padding-left: 152px;margin-top: 31px;margin-bottom: 0px;}
    .p113{text-align: justify;padding-right: 64px;margin-top: 29px;margin-bottom: 0px;text-indent: 4px;}
    .p114{text-align: left;padding-left: 28px;margin-top: 6px;margin-bottom: 0px;}
    .p115{text-align: left;padding-left: 28px;margin-top: 17px;margin-bottom: 0px;}
    .p116{text-align: left;padding-left: 28px;margin-top: 16px;margin-bottom: 0px;}
    .p117{text-align: left;padding-left: 56px;padding-right: 64px;margin-top: 17px;margin-bottom: 0px;text-indent: -28px;}
    .p118{text-align: left;padding-left: 10px;margin-top: 69px;margin-bottom: 0px;}
    .p119{text-align: right;padding-right: 27px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p120{text-align: left;padding-left: 28px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p121{text-align: left;padding-left: 140px;margin-top: 0px;margin-bottom: 0px;}
    .p122{text-align: left;padding-left: 69px;margin-top: 0px;margin-bottom: 0px;}
    .p123{text-align: left;padding-left: 105px;margin-top: 23px;margin-bottom: 0px;}
    .p124{text-align: justify;padding-right: 62px;margin-top: 10px;margin-bottom: 0px;}
    .p125{text-align: justify;padding-left: 28px;padding-right: 62px;margin-top: 11px;margin-bottom: 0px;text-indent: -28px;}
    .p126{text-align: justify;padding-left: 28px;padding-right: 62px;margin-top: 13px;margin-bottom: 0px;text-indent: -28px;}
    .p127{text-align: justify;padding-left: 28px;padding-right: 62px;margin-top: 12px;margin-bottom: 0px;text-indent: -28px;}
    .p128{text-align: left;padding-left: 28px;padding-right: 62px;margin-top: 12px;margin-bottom: 0px;text-indent: -28px;}
    .p129{text-align: right;padding-right: 17px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p130{text-align: left;padding-left: 22px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p131{text-align: left;padding-left: 3px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p132{text-align: left;padding-left: 67px;margin-top: 0px;margin-bottom: 0px;}
    .p133{text-align: left;padding-left: 203px;margin-top: 35px;margin-bottom: 0px;}
    .p134{text-align: justify;padding-right: 57px;margin-top: 13px;margin-bottom: 0px;}
    .p135{text-align: left;padding-left: 19px;padding-right: 61px;margin-top: 9px;margin-bottom: 0px;text-indent: -19px;}
    .p136{text-align: left;padding-left: 19px;padding-right: 57px;margin-top: 1px;margin-bottom: 0px;text-indent: -19px;}
    .p137{text-align: left;padding-left: 19px;padding-right: 61px;margin-top: 2px;margin-bottom: 0px;text-indent: -19px;}
    .p138{text-align: left;padding-left: 19px;padding-right: 61px;margin-top: 3px;margin-bottom: 0px;text-indent: -19px;}
    .p139{text-align: left;padding-right: 60px;margin-top: 11px;margin-bottom: 0px;}
    .p140{text-align: left;padding-left: 24px;margin-top: 9px;margin-bottom: 0px;}
    .p141{text-align: left;padding-left: 24px;margin-top: 2px;margin-bottom: 0px;}
    .p142{text-align: left;padding-left: 24px;margin-top: 1px;margin-bottom: 0px;}
    .p143{text-align: justify;padding-right: 61px;margin-top: 11px;margin-bottom: 0px;}
    .p144{text-align: left;padding-left: 24px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p145{text-align: right;padding-right: 25px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p146{text-align: left;padding-left: 537px;margin-top: 11px;margin-bottom: 0px;}
    .p147{text-align: left;padding-left: 302px;margin-top: 0px;margin-bottom: 0px;}
    .p148{text-align: left;padding-left: 537px;margin-top: 0px;margin-bottom: 0px;}
    .p149{text-align: left;padding-left: 93px;margin-top: 27px;margin-bottom: 0px;}
    .p150{text-align: left;margin-top: 11px;margin-bottom: 0px;}
    .p151{text-align: justify;padding-right: 58px;margin-top: 11px;margin-bottom: 0px;}
    .p152{text-align: left;padding-left: 24px;margin-top: 0px;margin-bottom: 0px;}
    .p153{text-align: justify;padding-left: 48px;padding-right: 57px;margin-top: 0px;margin-bottom: 0px;text-indent: -24px;}
    .p154{text-align: left;padding-left: 48px;padding-right: 57px;margin-top: 0px;margin-bottom: 0px;text-indent: -24px;}
    .p155{text-align: left;padding-right: 57px;margin-top: 0px;margin-bottom: 0px;}
    .p156{text-align: right;padding-right: 8px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p157{text-align: left;padding-left: 4px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p158{text-align: left;padding-left: 199px;margin-top: 23px;margin-bottom: 0px;}
    .p159{text-align: left;padding-left: 5px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p160{text-align: center;padding-right: 10px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p161{text-align: left;padding-left: 10px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p162{text-align: left;padding-left: 54px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p163{text-align: center;padding-left: 69px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p164{text-align: center;padding-right: 39px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p165{text-align: center;padding-left: 73px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p166{text-align: center;padding-right: 1px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p167{text-align: left;padding-left: 44px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p168{text-align: left;padding-left: 51px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p169{text-align: left;padding-left: 2px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p170{text-align: center;padding-right: 5px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p171{text-align: center;padding-right: 2px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p172{text-align: center;padding-right: 3px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p173{text-align: center;padding-right: 41px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p174{text-align: center;padding-right: 17px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p175{text-align: center;padding-right: 9px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p176{text-align: left;padding-left: 9px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p177{text-align: left;padding-left: 14px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p178{text-align: left;padding-left: 40px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p179{text-align: left;padding-left: 65px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p180{text-align: left;padding-left: 5px;margin-top: 12px;margin-bottom: 0px;}
    .p181{text-align: left;padding-left: 5px;padding-right: 41px;margin-top: 41px;margin-bottom: 0px;}
    .p182{text-align: left;padding-left: 67px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p183{text-align: left;padding-left: 62px;margin-top: 25px;margin-bottom: 0px;}
    .p184{text-align: left;padding-left: 62px;margin-top: 2px;margin-bottom: 0px;}
    .p185{text-align: left;padding-left: 62px;margin-top: 1px;margin-bottom: 0px;}
    .p186{text-align: left;padding-left: 169px;margin-top: 0px;margin-bottom: 0px;}
    .p187{text-align: left;padding-left: 3px;margin-top: 36px;margin-bottom: 0px;}
    .p188{text-align: right;padding-right: 5px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p189{text-align: right;padding-right: 39px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p190{text-align: right;padding-right: 224px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p191{text-align: center;padding-right: 7px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p192{text-align: left;padding-left: 17px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p193{text-align: right;padding-right: 38px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p194{text-align: left;padding-left: 18px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p195{text-align: right;padding-right: 194px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p196{text-align: left;padding-left: 19px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p197{text-align: left;padding-left: 59px;padding-right: 172px;margin-top: 0px;margin-bottom: 0px;text-indent: -24px;}
    .p198{text-align: left;padding-left: 33px;margin-top: 0px;margin-bottom: 0px;}
    .p199{text-align: left;padding-left: 32px;margin-top: 8px;margin-bottom: 0px;}
    .p200{text-align: left;padding-left: 2px;margin-top: 0px;margin-bottom: 0px;}
    .p201{text-align: left;padding-left: 33px;margin-top: 1px;margin-bottom: 0px;}
    .p202{text-align: left;padding-left: 59px;padding-right: 413px;margin-top: 1px;margin-bottom: 0px;}
    .p203{text-align: left;padding-left: 112px;padding-right: 140px;margin-top: 2px;margin-bottom: 0px;text-indent: -9px;}
    .p204{text-align: left;padding-left: 112px;margin-top: 4px;margin-bottom: 0px;}
    .p205{text-align: left;padding-left: 53px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p206{text-align: center;padding-right: 35px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p207{text-align: left;padding-left: 91px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p208{text-align: left;padding-right: 94px;margin-top: 16px;margin-bottom: 0px;}
    .p209{text-align: left;padding-left: 188px;margin-top: 16px;margin-bottom: 0px;}
    .p210{text-align: left;padding-left: 188px;margin-top: 0px;margin-bottom: 0px;}
    .p211{text-align: right;padding-right: 370px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p212{text-align: left;padding-left: 352px;margin-top: 0px;margin-bottom: 0px;}
    .p213{text-align: left;padding-left: 352px;margin-top: 17px;margin-bottom: 0px;}
    .p214{text-align: left;padding-left: 31px;margin-top: 12px;margin-bottom: 0px;}
    .p215{text-align: left;padding-left: 194px;margin-top: 0px;margin-bottom: 0px;}
    .p216{text-align: left;padding-left: 92px;margin-top: 8px;margin-bottom: 0px;}
    .p217{text-align: left;padding-left: 55px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p218{text-align: left;padding-left: 69px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p219{text-align: left;padding-left: 7px;margin-top: 3px;margin-bottom: 0px;}
    .p220{text-align: left;padding-left: 7px;margin-top: 0px;margin-bottom: 0px;}
    .p221{text-align: left;padding-left: 59px;margin-top: 10px;margin-bottom: 0px;}
    .p222{text-align: left;padding-left: 7px;margin-top: 24px;margin-bottom: 0px;}
    .p223{text-align: left;padding-left: 54px;margin-top: 8px;margin-bottom: 0px;}
    .p224{text-align: left;padding-left: 7px;margin-top: 27px;margin-bottom: 0px;}
    .p225{text-align: left;padding-left: 55px;margin-top: 7px;margin-bottom: 0px;}
    .p226{text-align: left;padding-left: 58px;margin-top: 6px;margin-bottom: 0px;}
    .p227{text-align: left;padding-left: 7px;margin-top: 12px;margin-bottom: 0px;}
    .p228{text-align: left;padding-left: 26px;margin-top: 1px;margin-bottom: 0px;}
    .p229{text-align: left;padding-left: 26px;margin-top: 0px;margin-bottom: 0px;}
    .p230{text-align: left;padding-left: 50px;padding-right: 96px;margin-top: 0px;margin-bottom: 0px;text-indent: -24px;}
    .p231{text-align: left;padding-left: 28px;margin-top: 0px;margin-bottom: 0px;}
    .p232{text-align: left;padding-left: 15px;padding-right: 99px;margin-top: 10px;margin-bottom: 0px;text-indent: -15px;}
    .p233{text-align: left;padding-left: 19px;margin-top: 1px;margin-bottom: 0px;}
    .p234{text-align: left;padding-left: 19px;margin-top: 0px;margin-bottom: 0px;}
    .p235{text-align: left;padding-left: 28px;padding-right: 20px;margin-top: 0px;margin-bottom: 0px;}
    .p236{text-align: left;padding-left: 28px;padding-right: 20px;margin-top: 0px;margin-bottom: 0px;text-indent: -9px;}
    .p237{text-align: left;padding-left: 28px;padding-right: 19px;margin-top: 0px;margin-bottom: 0px;text-indent: -9px;}
    .p238{text-align: left;padding-left: 16px;margin-top: 0px;margin-bottom: 0px;}
    .p239{text-align: left;padding-left: 16px;margin-top: 1px;margin-bottom: 0px;}
    .p240{text-align: left;padding-left: 19px;padding-right: 355px;margin-top: 8px;margin-bottom: 0px;}
    .p241{text-align: left;padding-left: 19px;margin-top: 4px;margin-bottom: 0px;}
    .p242{text-align: left;padding-left: 19px;padding-right: 320px;margin-top: 9px;margin-bottom: 0px;}
    .p243{text-align: left;padding-left: 19px;margin-top: 8px;margin-bottom: 0px;}
    .p244{text-align: left;padding-left: 23px;margin-top: 0px;margin-bottom: 0px;}
    .p245{text-align: left;padding-left: 93px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p246{text-align: right;padding-right: 22px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p247{text-align: justify;padding-left: 47px;padding-right: 57px;margin-top: 50px;margin-bottom: 0px;text-indent: 48px;}
    .p248{text-align: justify;padding-left: 47px;padding-right: 57px;margin-top: 26px;margin-bottom: 0px;text-indent: 48px;}
    .p249{text-align: left;padding-left: 47px;margin-top: 6px;margin-bottom: 0px;}
    .p250{text-align: justify;padding-left: 47px;padding-right: 57px;margin-top: 23px;margin-bottom: 0px;text-indent: 48px;}
    .p251{text-align: justify;padding-left: 47px;padding-right: 57px;margin-top: 27px;margin-bottom: 0px;text-indent: 48px;}
    .p252{text-align: left;padding-left: 47px;margin-top: 26px;margin-bottom: 0px;}
    .p253{text-align: left;padding-left: 272px;margin-top: 64px;margin-bottom: 0px;}
    .p254{text-align: left;padding-left: 47px;margin-top: 119px;margin-bottom: 0px;}
    .p255{text-align: left;padding-left: 47px;margin-top: 3px;margin-bottom: 0px;}
    .p256{text-align: left;padding-left: 47px;margin-top: 4px;margin-bottom: 0px;}
    .p257{text-align: right;padding-right: 242px;margin-top: 0px;margin-bottom: 0px;white-space: nowrap;}
    .p258{text-align: left;padding-left: 38px;padding-right: 61px;margin-top: 5px;margin-bottom: 0px;}
    .p259{text-align: left;padding-left: 38px;margin-top: 5px;margin-bottom: 0px;}

    .td0{padding: 0px;margin: 0px;width: 258px;vertical-align: bottom;}
    .td1{padding: 0px;margin: 0px;width: 295px;vertical-align: bottom;}
    .td2{border-left: #000000 1px solid;border-right: #000000 1px solid;border-top: #000000 1px solid;padding: 0px;margin: 0px;width: 255px;vertical-align: bottom;}
    .td3{border-right: #000000 1px solid;border-top: #000000 1px solid;padding: 0px;margin: 0px;width: 355px;vertical-align: bottom;}
    .td4{border-left: #000000 1px solid;border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 255px;vertical-align: bottom;}
    .td5{border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 355px;vertical-align: bottom;}
    .td6{border-left: #000000 1px solid;border-right: #000000 1px solid;padding: 0px;margin: 0px;width: 255px;vertical-align: bottom;}
    .td7{border-right: #000000 1px solid;padding: 0px;margin: 0px;width: 355px;vertical-align: bottom;}
    .td8{padding: 0px;margin: 0px;width: 245px;vertical-align: bottom;}
    .td9{padding: 0px;margin: 0px;width: 359px;vertical-align: bottom;}
    .td10{padding: 0px;margin: 0px;width: 263px;vertical-align: bottom;}
    .td11{border-top: #000000 1px solid;padding: 0px;margin: 0px;width: 193px;vertical-align: bottom;}
    .td12{padding: 0px;margin: 0px;width: 193px;vertical-align: bottom;}
    .td13{padding: 0px;margin: 0px;width: 234px;vertical-align: bottom;}
    .td14{padding: 0px;margin: 0px;width: 259px;vertical-align: bottom;}
    .td15{padding: 0px;margin: 0px;width: 155px;vertical-align: bottom;}
    .td16{padding: 0px;margin: 0px;width: 135px;vertical-align: bottom;}
    .td17{padding: 0px;margin: 0px;width: 16px;vertical-align: bottom;}
    .td18{padding: 0px;margin: 0px;width: 81px;vertical-align: bottom;}
    .td19{padding: 0px;margin: 0px;width: 28px;vertical-align: bottom;}
    .td20{padding: 0px;margin: 0px;width: 127px;vertical-align: bottom;background: #666666;}
    .td21{padding: 0px;margin: 0px;width: 135px;vertical-align: bottom;background: #666666;}
    .td22{padding: 0px;margin: 0px;width: 16px;vertical-align: bottom;background: #666666;}
    .td23{padding: 0px;margin: 0px;width: 97px;vertical-align: bottom;}
    .td24{padding: 0px;margin: 0px;width: 235px;vertical-align: bottom;}
    .td25{border-left: #000000 1px solid;border-right: #000000 1px solid;border-top: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 94px;vertical-align: bottom;}
    .td26{padding: 0px;margin: 0px;width: 96px;vertical-align: bottom;}
    .td27{padding: 0px;margin: 0px;width: 346px;vertical-align: bottom;}
    .td28{padding: 0px;margin: 0px;width: 63px;vertical-align: bottom;}
    .td29{padding: 0px;margin: 0px;width: 187px;vertical-align: bottom;}
    .td30{padding: 0px;margin: 0px;width: 72px;vertical-align: bottom;}
    .td31{padding: 0px;margin: 0px;width: 188px;vertical-align: bottom;}
    .td32{padding: 0px;margin: 0px;width: 73px;vertical-align: bottom;}
    .td33{border-left: #000000 1px solid;border-right: #000000 1px solid;border-top: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 150px;vertical-align: bottom;}
    .td34{border-right: #000000 1px solid;border-top: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 276px;vertical-align: bottom;}
    .td35{border-left: #000000 1px solid;border-right: #000000 1px solid;padding: 0px;margin: 0px;width: 150px;vertical-align: bottom;}
    .td36{border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 276px;vertical-align: bottom;}
    .td37{border-left: #000000 1px solid;border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 150px;vertical-align: bottom;}
    .td38{border-right: #000000 1px solid;padding: 0px;margin: 0px;width: 276px;vertical-align: bottom;}
    .td39{border-right: #000000 1px solid;padding: 0px;margin: 0px;width: 171px;vertical-align: bottom;}
    .td40{border-right: #000000 1px solid;border-top: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 90px;vertical-align: bottom;}
    .td41{padding: 0px;margin: 0px;width: 172px;vertical-align: bottom;}
    .td42{padding: 0px;margin: 0px;width: 91px;vertical-align: bottom;}
    .td43{border-right: #000000 1px solid;border-top: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 292px;vertical-align: bottom;}
    .td44{border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 292px;vertical-align: bottom;}
    .td45{padding: 0px;margin: 0px;width: 181px;vertical-align: bottom;}
    .td46{border-left: #000000 1px solid;border-right: #000000 1px solid;border-top: #000000 1px solid;padding: 0px;margin: 0px;width: 91px;vertical-align: bottom;}
    .td47{border-left: #000000 1px solid;border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 91px;vertical-align: bottom;}
    .td48{padding: 0px;margin: 0px;width: 93px;vertical-align: bottom;}
    .td49{padding: 0px;margin: 0px;width: 80px;vertical-align: bottom;}
    .td50{padding: 0px;margin: 0px;width: 2px;vertical-align: bottom;}
    .td51{padding: 0px;margin: 0px;width: 553px;vertical-align: bottom;}
    .td52{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 2px;vertical-align: bottom;}
    .td53{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 194px;vertical-align: bottom;}
    .td54{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 359px;vertical-align: bottom;}
    .td55{padding: 0px;margin: 0px;width: 194px;vertical-align: bottom;}
    .td56{border-right: #7f7f7f 1px solid;border-top: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 143px;vertical-align: bottom;}
    .td57{border-right: #7f7f7f 1px solid;border-top: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 77px;vertical-align: bottom;}
    .td58{padding: 0px;margin: 0px;width: 67px;vertical-align: bottom;}
    .td59{padding: 0px;margin: 0px;width: 75px;vertical-align: bottom;}
    .td60{padding: 0px;margin: 0px;width: 108px;vertical-align: bottom;}
    .td61{padding: 0px;margin: 0px;width: 11px;vertical-align: bottom;}
    .td62{padding: 0px;margin: 0px;width: 35px;vertical-align: bottom;}
    .td63{padding: 0px;margin: 0px;width: 31px;vertical-align: bottom;}
    .td64{padding: 0px;margin: 0px;width: 42px;vertical-align: bottom;}
    .td65{padding: 0px;margin: 0px;width: 8px;vertical-align: bottom;}
    .td66{padding: 0px;margin: 0px;width: 43px;vertical-align: bottom;}
    .td67{border-right: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 143px;vertical-align: bottom;}
    .td68{border-right: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 77px;vertical-align: bottom;}
    .td69{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 67px;vertical-align: bottom;}
    .td70{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 75px;vertical-align: bottom;}
    .td71{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 108px;vertical-align: bottom;}
    .td72{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 80px;vertical-align: bottom;}
    .td73{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 11px;vertical-align: bottom;}
    .td74{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 35px;vertical-align: bottom;}
    .td75{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 31px;vertical-align: bottom;}
    .td76{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 42px;vertical-align: bottom;}
    .td77{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 8px;vertical-align: bottom;}
    .td78{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 43px;vertical-align: bottom;}
    .td79{border-right: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 143px;vertical-align: bottom;}
    .td80{padding: 0px;margin: 0px;width: 78px;vertical-align: bottom;}
    .td81{border-right: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 74px;vertical-align: bottom;}
    .td82{border-right: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 107px;vertical-align: bottom;}
    .td83{padding: 0px;margin: 0px;width: 66px;vertical-align: bottom;}
    .td84{border-right: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 107px;vertical-align: bottom;}
    .td85{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 78px;vertical-align: bottom;}
    .td86{border-right: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 74px;vertical-align: bottom;}
    .td87{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 145px;vertical-align: bottom;}
    .td88{padding: 0px;margin: 0px;width: 145px;vertical-align: bottom;}
    .td89{padding: 0px;margin: 0px;width: 127px;vertical-align: bottom;}
    .td90{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 91px;vertical-align: bottom;}
    .td91{padding: 0px;margin: 0px;width: 407px;vertical-align: bottom;}
    .td92{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 51px;vertical-align: bottom;}
    .td93{border-right: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 144px;vertical-align: bottom;}
    .td94{border-right: #a6a6a6 1px solid;padding: 0px;margin: 0px;width: 74px;vertical-align: bottom;}
    .td95{border-right: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 10px;vertical-align: bottom;}
    .td96{padding: 0px;margin: 0px;width: 159px;vertical-align: bottom;}
    .td97{border-right: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 66px;vertical-align: bottom;}
    .td98{border-right: #a6a6a6 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 74px;vertical-align: bottom;}
    .td99{border-right: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 10px;vertical-align: bottom;}
    .td100{padding: 0px;margin: 0px;width: 124px;vertical-align: bottom;}
    .td101{border-right: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 66px;vertical-align: bottom;}
    .td102{border-right: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 34px;vertical-align: bottom;}
    .td103{border-right: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 30px;vertical-align: bottom;}
    .td104{border-right: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 41px;vertical-align: bottom;}
    .td105{border-right: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 34px;vertical-align: bottom;}
    .td106{border-right: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 30px;vertical-align: bottom;}
    .td107{border-right: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 41px;vertical-align: bottom;}
    .td108{border-right: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 65px;vertical-align: bottom;}
    .td109{border-right: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 144px;vertical-align: bottom;}
    .td110{border-right: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 65px;vertical-align: bottom;}
    .td111{border-right: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 77px;vertical-align: bottom;}
    .td112{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 250px;vertical-align: bottom;}
    .td113{padding: 0px;margin: 0px;width: 358px;vertical-align: bottom;}
    .td114{border-right: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 221px;vertical-align: bottom;}
    .td115{border-right: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 90px;vertical-align: bottom;}
    .td116{border-right: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 221px;vertical-align: bottom;}
    .td117{padding: 0px;margin: 0px;width: 144px;vertical-align: bottom;}
    .td118{padding: 0px;margin: 0px;width: 457px;vertical-align: bottom;}
    .td119{padding: 0px;margin: 0px;width: 328px;vertical-align: bottom;}
    .td120{border-left: #7f7f7f 1px solid;border-right: #7f7f7f 1px solid;border-top: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 287px;vertical-align: bottom;}
    .td121{border-right: #7f7f7f 1px solid;border-top: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 390px;vertical-align: bottom;}
    .td122{border-left: #7f7f7f 1px solid;border-right: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 287px;vertical-align: bottom;}
    .td123{border-right: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 390px;vertical-align: bottom;}
    .td124{padding: 0px;margin: 0px;width: 21px;vertical-align: bottom;}
    .td125{padding: 0px;margin: 0px;width: 136px;vertical-align: bottom;}
    .td126{padding: 0px;margin: 0px;width: 15px;vertical-align: bottom;}
    .td127{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 19px;vertical-align: bottom;}
    .td128{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 69px;vertical-align: bottom;}
    .td129{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 21px;vertical-align: bottom;}
    .td130{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 54px;vertical-align: bottom;}
    .td131{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 38px;vertical-align: bottom;}
    .td132{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 262px;vertical-align: bottom;}
    .td133{padding: 0px;margin: 0px;width: 19px;vertical-align: bottom;}
    .td134{padding: 0px;margin: 0px;width: 69px;vertical-align: bottom;}
    .td135{padding: 0px;margin: 0px;width: 54px;vertical-align: bottom;}
    .td136{padding: 0px;margin: 0px;width: 38px;vertical-align: bottom;}
    .td137{padding: 0px;margin: 0px;width: 262px;vertical-align: bottom;}
    .td138{padding: 0px;margin: 0px;width: 58px;vertical-align: bottom;}
    .td139{padding: 0px;margin: 0px;width: 47px;vertical-align: bottom;}
    .td140{border-right: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 25px;vertical-align: bottom;}
    .td141{border-top: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 5px;vertical-align: bottom;}
    .td142{border-right: #7f7f7f 1px solid;border-top: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 14px;vertical-align: bottom;}
    .td143{border-top: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 19px;vertical-align: bottom;}
    .td144{border-top: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 69px;vertical-align: bottom;}
    .td145{border-top: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 21px;vertical-align: bottom;}
    .td146{border-top: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 54px;vertical-align: bottom;}
    .td147{border-top: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 300px;vertical-align: bottom;}
    .td148{padding: 0px;margin: 0px;width: 5px;vertical-align: bottom;}
    .td149{border-right: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 14px;vertical-align: bottom;}
    .td150{border-right: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 130px;vertical-align: bottom;}
    .td151{padding: 0px;margin: 0px;width: 90px;vertical-align: bottom;}
    .td152{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 5px;vertical-align: bottom;}
    .td153{border-right: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 14px;vertical-align: bottom;}
    .td154{border-right: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 46px;vertical-align: bottom;}
    .td155{border-top: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 31px;vertical-align: bottom;}
    .td156{border-right: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 18px;vertical-align: bottom;}
    .td157{border-right: #7f7f7f 1px solid;border-top: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 42px;vertical-align: bottom;}
    .td158{padding: 0px;margin: 0px;width: 26px;vertical-align: bottom;}
    .td159{border-top: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 38px;vertical-align: bottom;}
    .td160{border-top: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 262px;vertical-align: bottom;}
    .td161{padding: 0px;margin: 0px;width: 170px;vertical-align: bottom;}
    .td162{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 144px;vertical-align: bottom;}
    .td163{padding: 0px;margin: 0px;width: 478px;vertical-align: bottom;}
    .td164{border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 26px;vertical-align: bottom;}
    .td165{padding: 0px;margin: 0px;width: 112px;vertical-align: bottom;}
    .td166{padding: 0px;margin: 0px;width: 206px;vertical-align: bottom;}
    .td167{padding: 0px;margin: 0px;width: 303px;vertical-align: bottom;}
    .td168{padding: 0px;margin: 0px;width: 185px;vertical-align: bottom;}
    .td169{padding: 0px;margin: 0px;width: 190px;vertical-align: bottom;}
    .td170{border-top: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 65px;vertical-align: bottom;}
    .td171{border-top: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 23px;vertical-align: bottom;}
    .td172{border-top: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 70px;vertical-align: bottom;}
    .td173{padding: 0px;margin: 0px;width: 255px;vertical-align: bottom;}
    .td174{border-right: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 22px;vertical-align: bottom;}
    .td175{border-right: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 69px;vertical-align: bottom;}
    .td176{border-right: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 69px;vertical-align: bottom;}
    .td177{border-right: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 110px;vertical-align: bottom;}
    .td178{border-right: #7f7f7f 1px solid;border-top: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 26px;vertical-align: bottom;}
    .td179{padding: 0px;margin: 0px;width: 151px;vertical-align: bottom;}
    .td180{border-right: #7f7f7f 1px solid;border-bottom: #7f7f7f 1px solid;padding: 0px;margin: 0px;width: 26px;vertical-align: bottom;}
    .td181{padding: 0px;margin: 0px;width: 129px;vertical-align: bottom;}
    .td182{padding: 0px;margin: 0px;width: 467px;vertical-align: bottom;}
    .td183{border-left: #000000 1px solid;border-right: #000000 1px solid;border-top: #000000 1px solid;padding: 0px;margin: 0px;width: 234px;vertical-align: bottom;}
    .td184{border-right: #000000 1px solid;border-top: #000000 1px solid;padding: 0px;margin: 0px;width: 233px;vertical-align: bottom;}
    .td185{border-left: #000000 1px solid;border-right: #000000 1px solid;padding: 0px;margin: 0px;width: 234px;vertical-align: bottom;}
    .td186{border-right: #000000 1px solid;padding: 0px;margin: 0px;width: 233px;vertical-align: bottom;}
    .td187{border-left: #000000 1px solid;border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 234px;vertical-align: bottom;}
    .td188{border-right: #000000 1px solid;border-bottom: #000000 1px solid;padding: 0px;margin: 0px;width: 233px;vertical-align: bottom;}
    .td189{padding: 0px;margin: 0px;width: 48px;vertical-align: bottom;}
    .td190{padding: 0px;margin: 0px;width: 71px;vertical-align: bottom;background: #c0c0c0;}
    .td191{padding: 0px;margin: 0px;width: 316px;vertical-align: bottom;}
    .td192{padding: 0px;margin: 0px;width: 48px;vertical-align: bottom;background: #c0c0c0;}
    .td193{padding: 0px;margin: 0px;width: 85px;vertical-align: bottom;}

    .tr0{height: 15px;}
    .tr1{height: 17px;}
    .tr2{height: 35px;}
    .tr3{height: 19px;}
    .tr4{height: 18px;}
    .tr5{height: 20px;}
    .tr6{height: 22px;}
    .tr7{height: 4px;}
    .tr8{height: 24px;}
    .tr9{height: 1px;}
    .tr10{height: 16px;}
    .tr11{height: 122px;}
    .tr12{height: 116px;}
    .tr13{height: 14px;}
    .tr14{height: 23px;}
    .tr15{height: 6px;}
    .tr16{height: 26px;}
    .tr17{height: 8px;}
    .tr18{height: 5px;}
    .tr19{height: 2px;}
    .tr20{height: 117px;}
    .tr21{height: 115px;}
    .tr22{height: 11px;}
    .tr23{height: 7px;}
    .tr24{height: 105px;}
    .tr25{height: 104px;}
    .tr26{height: 33px;}
    .tr27{height: 3px;}
    .tr28{height: 29px;}
    .tr29{height: 28px;}
    .tr30{height: 9px;}
    .tr31{height: 34px;}
    .tr32{height: 27px;}
    .tr33{height: 10px;}
    .tr34{height: 37px;}
    .tr35{height: 21px;}
    .tr36{height: 49px;}
    .tr37{height: 13px;}
    .tr38{height: 12px;}
    .tr39{height: 41px;}
    .tr40{height: 30px;}

    .t0{width: 553px;margin-left: 33px;margin-top: 128px;font: bold 12px 'Calibri Light';}
    .t1{width: 612px;margin-left: 39px;margin-top: 31px;font: 16px 'Arial Narrow';}
    .t2{width: 604px;margin-left: 43px;margin-top: 115px;font: bold 15px 'Arial';}
    .t3{width: 456px;margin-left: 134px;margin-top: 193px;font: bold 12px 'Tahoma';}
    .t4{width: 493px;margin-left: 48px;margin-top: 143px;font: 13px 'Tahoma';}
    .t5{width: 387px;margin-left: 45px;margin-top: 30px;font: bold 13px 'Tahoma';}
    .t6{width: 331px;margin-left: 104px;margin-top: 13px;font: bold 12px 'Tahoma';}
    .t7{width: 409px;margin-left: 65px;margin-top: 84px;font: italic 12px 'Times New Roman';}
    .t8{width: 259px;margin-left: 193px;margin-top: 143px;font: 11px 'Tahoma';}
    .t9{width: 261px;margin-left: 152px;margin-top: 145px;font: 11px 'Tahoma';}
    .t10{width: 428px;margin-left: 28px;margin-top: 4px;font: 11px 'Arial';}
    .t11{width: 262px;margin-left: 165px;margin-top: 21px;font: bold 9px 'Arial';}
    .t12{width: 444px;margin-left: 20px;margin-top: 19px;font: 11px 'Tahoma';}
    .t13{width: 272px;margin-left: 166px;margin-top: 10px;font: bold 9px 'Tahoma';}
    .t14{width: 663px;margin-top: 13px;font: bold 15px 'Times New Roman';}
    .t15{width: 722px;margin-top: 25px;font: 13px 'Tahoma';}
    .t16{width: 679px;margin-top: 100px;font: bold 15px 'Tahoma';}
    .t17{width: 635px;margin-left: 29px;font: 13px 'Tahoma';}
    .t18{width: 509px;margin-left: 29px;font: 13px 'Tahoma';}
    .t19{width: 374px;margin-left: 59px;margin-top: 1px;font: 13px 'Tahoma';}
    .t20{width: 289px;margin-left: 112px;margin-top: 1px;font: bold 13px 'Tahoma';}
    .t21{width: 596px;margin-top: 7px;font: bold 13px 'Tahoma';}
    .t22{width: 469px;margin-top: 4px;font: bold 12px 'Tahoma';}
    .t23{width: 478px;margin-left: 47px;margin-top: 61px;font: bold 15px 'Calibri Light';}
    .t24{width: 520px;margin-left: 38px;margin-top: 26px;font: bold 15px 'Calibri Light';}
</style>

<div id="page_1">


    <p class="p0 ft0">73273262</p>
    <p class="p1 ft1">CONTRATO DE TRABAJO SUJETO A MODALIDAD INTERMITENTE</p>
    <p class="p2 ft3"><span class="ft2">Conste mediante el presente documento el </span>Contrato de Trabajo sujeto a modalidad Intermitente <span class="ft2">en adelante </span>EL CONTRATO-<span class="ft2">,</span><span class="ft2"> que se suscribe de conformidad con lo establecido en la Ley N° 27360, Ley de Promoción del Sector Agrario; y los artículos 64° al 66° del Texto Único Ordenado del Decreto Legislativo Nº 728, Ley de Productividad y Competitividad Laboral, D.S. Nº </span><span class="ft2">003-97-tr</span><span class="ft2"> (en adelante LPCL), entre:</span></p>
    <p class="p3 ft2"><span class="ft4"></span><span class="ft5">SOCIEDAD AGRICOLA RAPEL S.A.C.</span>, R.U.C. Nº 20451779711, con domicilio en Caserío el Papayo Mz. O, Distrito de Castilla, Provincia y Departamento de Piura, debidamente representada por su Apoderado, Sr. Carrillo Curay Federico, identificado con Documento Nacional de Identidad Nº 44554215, a la que en adelante le denominará <span class="ft3">EL EMPLEADOR</span>; y de la otra parte,</p>
    <p class="p4 ft3"><span class="ft4"></span><span class="ft6">RUFINO ALAMA, LUIS </span><span class="ft2">con DNI o C.E. Nº </span>73273262, <span class="ft2">con domicilio en </span>MZ. X LT. 185 CASERIO SANTA ANA - TAMBO GRANDE<span class="ft2">, Distrito de </span>TAMBO GRANDE<span class="ft2">, Provincia de </span>PIURA<span class="ft2">, Departamento de </span>PIURA<span class="ft2">, con fecha de nacimiento </span>06/10/1997 <span class="ft2">y de Nacionalidad </span>PERUANO (A)<span class="ft2">, a quien en adelante se le denominará </span>EL TRABAJADOR<span class="ft2">.</span></p>
    <p class="p5 ft2">En los términos y condiciones que constan en las cláusulas siguientes:</p>
    <p class="p6 ft3"><span class="ft1">PRIMERA</span>: Antecedentes.-</p>
    <p class="p7 ft2"><span class="ft2">1.1</span><span class="ft7">EL EMPLEADOR </span>es una persona jurídica cuya actividad principales de naturaleza agrícola, desarrollando los procesos necesarios involucrados en la siembra, cosecha, empaque, y exportación del producto agrícola.</p>
    <p class="p8 ft2"><span class="ft2">1.2</span><span class="ft7">EL TRABAJADOR </span>declara estar capacitado para desempeñarse en el cargo para el que se le contrata, contando con experiencia para cumplir con la prestación de servicios en el cargo objeto de <span class="ft3">EL CONTRATO.</span></p>
    <p class="p9 ft2"><span class="ft2">1.3</span><span class="ft8">Los antecedentes antes señalados y las competencias y aptitudes que son inherentes a los mismos han sido tenidos en especial consideración por </span><span class="ft3">EL EMPLEADOR </span>para la contratación de <span class="ft3">EL TRABAJADOR</span>, acordando las partes que tales competencias y aptitudes tienen el carácter de esenciales para la celebración de este contrato.</p>
    <p class="p10 ft3"><span class="ft1">SEGUNDO</span><span class="ft2">: </span>Causa objetiva de la contratación.-</p>
    <p class="p9 ft2"><span class="ft2">2.1</span><span class="ft8">Considerando la naturaleza agrícola de sus actividades, las mismas que son de carácter permanente pero discontinúo, con períodos de incremento y de inactividad, </span><span class="ft3">EL EMPLEADOR </span>requiere contratar a plazo fijo y bajo la modalidad <span class="ft3">INTERMITENTE </span>los servicios de <span class="ft3">EL</span></p>
    <p class="p11 ft3">TRABAJADOR.</p>
    <p class="p9 ft2"><span class="ft2">2.2</span><span class="ft7">EL EMPLEADOR, </span>conforme lo señalado en el párrafo anterior, precisa que la intermitencia se basa en la naturaleza agrícola de las actividades a desarrollar, las cuales están afectas a factores externos como clima, suelo, crecimiento del producto agrícola, etc. Dichos factores externos escapan al control del <span class="ft3">EMPLEADOR</span>, por lo cual la necesidad del recurso humano no puede ser prevista con exactitud, y se irá adecuando en cada oportunidad, según el requerimiento de las áreas involucradas.</p>
    <p class="p10 ft3"><span class="ft1">TERCERO</span>: Objeto.-</p>
    <p class="p8 ft2"><span class="ft2">3.1</span><span class="ft8">En razón de la causa objetiva señalada en la cláusula anterior, </span><span class="ft3">EL EMPLEADOR </span>contrata a plazo fijo bajo la modalidad indicada, los servicios de <span class="ft3">EL TRABAJADOR </span>para que desempeñe el cargo de <span class="ft3">OBRERO DE CAMPO.</span></p>
    <p class="p9 ft2"><span class="ft2">3.2</span><span class="ft7">EL TRABAJADOR </span>conoce y entiende que <span class="ft3">EL EMPLEADOR </span>cuenta con facultades de dirección reconocida en el artículo 9° de la LPCL, por lo cual, en ejercicio legítimo de la misma, <span class="ft3">EL EMPLEADOR </span>puede organizar y controlar el buen cumplimiento de las obligaciones de <span class="ft3">EL TRABAJADOR</span>.</p>
    <p class="p12 ft2"><span class="ft2">3.3</span><span class="ft7">EL EMPLEADOR </span>en función de sus necesidades y requerimientos podrá modificar las condiciones de la prestación de los servicios objeto de la relación laboral, siendo pasibles de variación lo referente a la jornada y horario de trabajo, designación del centro de labores a cualquiera de las sedes que existan en su oportunidad, forma, funciones, categoría, modalidad dentro de los límites que la razonabilidad y la ley establecen. <span class="ft3">EL TRABAJADOR </span>entiende que dichas variaciones no significan una rebaja de categoría y/o remuneración.</p>
    <p class="p10 ft3"><span class="ft1">CUARTO</span>: Funciones del TRABAJADOR.-</p>
    <p class="p13 ft9"><span class="ft9">4.1</span><span class="ft10">La prestación de los servicios de </span><span class="ft11">EL TRABAJADOR </span>comprende todas aquellas actividades relacionadas y complementarias al cargo indicado en la Cláusula Tercera de <span class="ft11">EL CONTRATO</span>, así como aquellas que se le indiquen en función del cumplimiento de las actividades de <span class="ft11">EL</span></p>
    <p class="p14 ft3">EMPLEADOR.</p>
    <p class="p15 ft2"><span class="ft2">4.2</span><span class="ft7">EL EMPLEADOR </span>señala que <span class="ft3">EL TRABAJADOR </span>deberá realizar las siguientes funciones:</p>
    <p class="p16 ft2"><span class="ft12">I.</span><span class="ft13">Funciones específicas.</span></p>
    <p class="p17 ft2"><span class="ft12">II.</span><span class="ft14">Labores de siembra, cosecha y empaque del producto agrícola para ser exportado.</span></p>
    <p class="p11 ft2"><span class="ft12">III. </span>Cualquier otra que le sea asignada por <span class="ft3">EL EMPLEADOR.</span></p>
    <p class="p18 ft2"><span class="ft2">4.3</span><span class="ft7">EL EMPLEADOR </span>señala de manera expresa que las funciones detalladas se efectúan únicamente con fines enunciativos; en consecuencia, <span class="ft3">EL TRABAJADOR </span>deberá realizar todas aquellas funciones vinculadas a la naturaleza del cargo objeto de <span class="ft3">EL CONTRATO</span>, según lo establecido por <span class="ft3">EL EMPLEADOR.</span></p>
    <p class="p19 ft3"><span class="ft1">QUINTO:</span> Plazo del Contrato.-</p>
    <p class="p6 ft2"><span class="ft2">5.1</span><span class="ft8">El plazo de vigencia del presente contrato es de tres (3) meses, y rige desde el </span><span class="ft3">03 de Junio del 2020 hasta el 02 de Setiembre del 2020.</span></p>
    <p class="p9 ft2"><span class="ft2">5.2</span><span class="ft7">EL EMPLEADOR </span>no está obligado a dar aviso adicional alguno referente al término del presente contrato, operando su extinción en la fecha de su vencimiento, oportunidad en la cual se abonará a <span class="ft3">EL TRABAJADOR </span>los beneficios sociales que le pudieran corresponder, de acuerdo a Ley.</p>
    <p class="p20 ft2"><span class="ft2">5.3</span><span class="ft8">Si la naturaleza del trabajo así lo requiere se podrá prorrogar el tiempo de vigencia de </span><span class="ft3">EL CONTRATO</span>, en común acuerdo de ambas partes, debiéndose de firmar en este caso la prórroga respectiva.</p>
    <p class="p9 ft2"><span class="ft2">5.4</span><span class="ft8">La suspensión de </span><span class="ft3">EL CONTRATO</span>, cualquiera que fuera el supuesto, no interrumpe ni suspende el plazo de extinción de la relación laboral sujeta a plazo fijo. Por ende, si por alguna circunstancia <span class="ft3">EL TRABAJADOR </span>estuviera percibiendo prestaciones por enfermedad o accidente de trabajo al vencimiento calendario del presente contrato, ello no significa en forma alguna la prolongación del plazo fijo contratado, ni la conversión de éste en indeterminado.</p>
    <p class="p21 ft2">Siendo así, simultáneamente a la cesación en la percepción de prestaciones, se producirá la terminación de la relación contractual de trabajo descrita en el presente documento, con efectividad a la fecha de vencimiento del mismo.</p>
    <p class="p15 ft3"><span class="ft1">SEXTO</span>: Período de Prueba.-</p>
    </div>
    <div id="page_2">


    <p class="p6 ft2"><span class="ft3">EL EMPLEADOR </span>señala que conforme a lo establecido en el artículo 10° de la LPCL-, <span class="ft3">EL TRABAJADOR </span>estará sujeto a un período de prueba de tres</p>
    <p class="p22 ft2"><span class="ft9">(3)</span><span class="ft15">meses. </span><span class="ft3">EL TRABAJADOR </span>conoce y entiende que durante este período de prueba <span class="ft3">EL EMPLEADOR </span>podrá extinguir la relación laboralsin expresión de causa, y ello no generará el pago de concepto indemnizatorio alguno.</p>
    <p class="p23 ft3"><span class="ft1">SETIMO</span>: Jornada y horario de trabajo.-</p>
    <p class="p9 ft2"><span class="ft2">7.1</span><span class="ft7">EL TRABAJADOR </span>deberá cumplir el horario de trabajo señalado por <span class="ft3">EL EMPLEADOR</span>, la cual será fijada respetando la jornada máxima de 48 horas semanales, ello de conformidad con lo previsto en el artículo 1º del Decreto Supremo Nº 007-2002-tr, Texto Único Ordenado de la Ley de Jornada de Trabajo, Horario y Trabajo en Sobretiempo.</p>
    <p class="p24 ft2"><span class="ft2">7.2</span><span class="ft8">Conforme a ello, las partes convienen en que </span><span class="ft3">EL EMPLEADOR </span>de acuerdo con las necesidades operativas que surjan, tendrá la facultad de determinar y variar los días de trabajo, los días de descanso, los horarios y las jornadas de trabajo, toda vez que ambas partes conocen y entienden que las labores a cargo del <span class="ft3">TRABAJADOR </span>están sujetas a condiciones variables -tanto de suelo como climáticas- por lo cual se requiere que existan las condiciones propicias para que <span class="ft3">EL TRABAJADOR </span>pueda cumplir con la prestación a su cargo. <span class="ft3">EL TRABAJADOR </span>presta expreso consentimiento a esta prerrogativa de <span class="ft3">EL EMPLEADOR</span>.</p>
    <p class="p18 ft2"><span class="ft2">7.3</span><span class="ft8">Las ausencias injustificadas por parte de </span><span class="ft3">EL TRABAJADOR </span>implican la pérdida de la remuneración proporcionalmente a la duración de dicha ausencia. Sin perjuicio de ello, <span class="ft3">EL TRABAJADOR </span>entiende que en los supuestos de ausencias injustificadas <span class="ft3">EL EMPLEADOR </span>podrá aplicar las medidas disciplinarias que estime convenientes, según su normativa interna, así como lo previsto en la legislación laboral; ello en ejercicio legítimo de su facultad disciplinaria.</p>
    <p class="p18 ft2"><span class="ft2">7.4</span><span class="ft7">EL TRABAJADOR </span>tendrá derecho a gozar de cuarenta y cinco (45) minutos de refrigerio, tiempo que no forma parte de la jornada de trabajo, tal como se establece en el artículo 7° del Texto Único Ordenado de la Ley de Jornada de Trabajo, el cual se hará efectivo en función de la organización del área en la que prestará labores <span class="ft3">EL TRABAJADOR.</span></p>
    <p class="p25 ft2"><span class="ft2">7.5</span><span class="ft7">EL EMPLEADOR </span>señala que <span class="ft3">EL TRABAJADOR </span>tendrá derecho a gozar del día de descanso semanal obligatorio conforme lo establecido en el artículo 1° del Decreto Legislativo N° 713.</p>
    <p class="p23 ft3"><span class="ft1">OCTAVO</span>: Obligaciones del Trabajador.-</p>
    <p class="p26 ft2"><span class="ft2">8.1</span><span class="ft7">EL TRABAJADOR </span>debe desarrollar las labores a su cargo de manera puntual, responsable y eficiente, cumpliendo con las indicaciones e instrucciones impartidas por <span class="ft3">EL EMPLEADOR</span>.</p>
    <p class="p27 ft9"><span class="ft9">8.2</span><span class="ft16">EL TRABAJADOR </span>recibirá una copia del Reglamento Interno de Trabajo, del Reglamento de Seguridad y Salud en el Trabajo, y de las políticas establecidas por <span class="ft11">EL EMPLEADOR</span>, estando obligado a revisarlos, conocer su contenido y cumplir con lo señalado en dichos documentos.</p>
    <p class="p10 ft3"><span class="ft1">NOVENO</span><span class="ft2">: </span>Remuneración.-</p>
    <p class="p9 ft2"><span class="ft2">9.1</span><span class="ft8">En contraprestación a los servicios prestados por </span><span class="ft3">EL TRABAJADOR, EL EMPLEADOR </span>se obliga a pagar una remuneración diaria (jornal) bruta ascendente a <span class="ft3">S/. 39.19 (TREINTA Y NUEVE CON 19/100 SOLES)</span>, monto del cual se deducirán las aportaciones y descuentos establecidos en la ley.</p>
    <p class="p28 ft2"><span class="ft2">9.2</span><span class="ft7">EL EMPLEADOR </span>al encontrarse acogido al régimen agrario, precisa que la remuneración abonada a <span class="ft3">EL TRABAJADOR </span>incluye la compensación por tiempo de servicios y las gratificaciones de fiestas patrias y de navidad, conforme lo previsto por el Art.7° de la Ley N° 27360.</p>
    <p class="p29 ft2"><span class="ft2">9.3</span><span class="ft7">EL TRABAJADOR </span>declara que la remuneración señalada en esta cláusula constituye una adecuada compensación por los servicios prestados a <span class="ft3">EL EMPLEADOR</span>, así como por las obligaciones asumidas en el presente contrato.</p>
    <p class="p30 ft3"><span class="ft1">DECIMO</span>: Entrega de Herramientas de Trabajo.-</p>
    <p class="p9 ft2"><span class="ft2">10.1</span><span class="ft17">EL EMPLEADOR </span>proporcionará a <span class="ft3">EL TRABAJADOR </span>los materiales y herramientas de trabajo necesarias para el adecuado desarrollo de sus actividades, <span class="ft3">EL TRABAJADOR </span>será responsable de mantener el buen estado de las herramientas y/bienes de trabajo asignados, los mismas que sólo deben sufrir el desgaste propio y natural provocado por el uso normal.</p>
    <p class="p28 ft2"><span class="ft2">10.2</span><span class="ft17">EL TRABAJADOR </span>será responsable por los daños, pérdidas, extravíos o robos de las herramientas y/o bienes de trabajo que se le hayan asignado. En este sentido y conforme lo establecido en la “Política de Entrega y Manejo de Herramientas, Bienes y Vehículos de Trabajo”</p>
    <p class="p31 ft2"><span class="ft3">EL TRABAJADOR </span>autoriza expresamente a <span class="ft3">EL EMPLEADOR </span>a deducir de su remuneración (de su liquidación de beneficios sociales en caso de extinción de la relación laboral) el costo de la reparación o reposición de la o las herramientas de trabajo.</p>
    <p class="p23 ft3"><span class="ft1">DECIMO PRIMERO</span>: Buena Fe.-</p>
    <p class="p32 ft9"><span class="ft11">EL TRABAJADOR </span>se obliga en forma expresa a poner al servicio del <span class="ft11">EMPLEADOR </span>toda su capacidad y lealtad, así como a la protección de sus intereses, en razón del cargo para el cual se le contrata. Asimismo, desarrollará las labores encargadas según las indicaciones impartidas por <span class="ft11">EL</span></p>
    <p class="p33 ft3">EMPLEADOR.</p>
    <p class="p34 ft3"><span class="ft1">DECIMOSEGUNDO</span>: Exclusividad.-</p>
    <p class="p35 ft2">Los servicios de <span class="ft3">EL TRABAJADOR </span>son contratados con el carácter de exclusividad, de manera tal que durante la vigencia de la relación laboral <span class="ft3">EL TRABAJADOR </span>se compromete a dedicar todo su tiempo, desplegar la energía y aplicar la experiencia que sean necesarios para el servicio y la protección de los intereses de <span class="ft3">EL EMPLEADOR</span>, no pudiendo dedicarse a actividades por cuenta propia o de terceros que le distraigan del cumplimiento cabal de sus obligaciones para con <span class="ft3">EL EMPLEADOR</span>.</p>
    <p class="p10 ft3"><span class="ft1">DECIMO TERCERO</span>: Registro del Contrato.-</p>
    <p class="p36 ft2"><span class="ft3">EL EMPLEADOR </span>se obliga a inscribir a <span class="ft3">EL TRABAJADOR </span>en los registros correspondientes, así como a poner conocimiento de la Autoridad Administrativa de Trabajo el presente contrato para su conocimiento y registro, en cumplimiento de lo dispuesto en el Decreto Supremo Nº 003-97-tr.</p>
    <p class="p23 ft3"><span class="ft1">DECIMO CUARTO</span>: Sistema de Pensiones.-</p>
    <p class="p37 ft2">De acuerdo al inciso 5 del Art.9° de la Ley N° 27360 y de los artículos 15 y 16 de la Ley 28991,<span class="ft3">EL TRABAJADOR </span>dentro del plazo legal comunicará a <span class="ft3">EL EMPLEADOR </span>su decisión respecto del derecho a afiliarse a cualquiera de los regímenes previsionales, en el supuesto que <span class="ft3">EL TRABAJADOR </span>no cumpla con la comunicación indicada, <span class="ft3">EL EMPLEADOR </span>lo afiliará al Sistema Privado de Pensiones (AFP) en las condiciones señaladas en el artículo 6° del TUO de la Ley del Sistema Privado de Pensiones.</p>
    </div>
    <div id="page_3">


    <p class="p6 ft3"><span class="ft1">DECIMO QUINTO</span>: Seguridad y Salud.-</p>
    <p class="p38 ft2"><span class="ft2">15.1</span><span class="ft18">En cumplimiento de lo establecido en la Ley N° 29783, Ley de Seguridad y Salud en el Trabajo, y habiendo analizado el riesgo de las funciones propias del cargo a desempeñar por </span><span class="ft3">EL TRABAJADOR</span>, con la finalidad de dar cumplimiento a las recomendaciones en materia de seguridad y salud destinadas a evitar cualquier riesgo para <span class="ft3">EL TRABAJADOR </span>durante el desarrollo de las actividades del cargo indicado, se señala de manera expresa la obligación de ejecutar las recomendaciones aplicables, las cuales serán desarrolladas en el Anexo 1 del presente documento.</p>
    <p class="p39 ft2"><span class="ft2">15.2</span><span class="ft17">EL TRABAJADOR </span>entiende que es su obligación conocer el Reglamento de Seguridad y Salud que se le entregará al inicio de la relación laboral, así como asistir a las capacitaciones sobre la materia que sean programadas por <span class="ft3">EL EMPLEADOR</span>.</p>
    <p class="p13 ft23"><span class="ft2">15.3</span><span class="ft19">EL EMPLEADOR </span>establece de manera expresa que el incumplimiento de obligaciones en materia de seguridad y salud por parte de <span class="ft20">EL TRABAJADOR </span>son consideradas faltas graves toda vez que suponen un riesgo para la salud e integridad del mismo y de las otras personas que se encuentren en el centro de trabajo. Por lo cual, <span class="ft20">EL EMPLEADOR establece como lineamiento de actuación el de “</span><span class="ft21">tolerancia cero</span><span class="ft22">” </span>respecto a faltas cometidas en materia de seguridad y salud, sancionando las mismas con el despido y la imposibilidad de ser recontratado.</p>
    <p class="p30 ft3"><span class="ft1">DECIMOSEXTO</span>: Del período de inactividad.-</p>
    <p class="p8 ft2"><span class="ft2">16.1</span><span class="ft18">Conforme la naturaleza intermitente de las actividades realizadas por </span><span class="ft3">EL TRABAJADOR, </span>en el supuesto que exista un período de inactividad<span class="ft3">, EL CONTRATO </span>podrá ser suspendido. El período de suspensión no afecta la vigencia de <span class="ft3">EL CONTRATO.</span></p>
    <p class="p7 ft2"><span class="ft2">16.2</span><span class="ft18">La suspensión será comunicada a </span><span class="ft3">EL TRABAJADOR</span>, indicándosele la fecha probable del reinicio de las actividades. En el supuesto que en la fecha señalada no existan las condiciones adecuadas para el reinicio de labores, se procederá a indicar una nueva fecha.</p>
    <p class="p9 ft2"><span class="ft2">16.3</span><span class="ft18">El cálculo de los beneficios sociales de </span><span class="ft3">ELTRABAJADOR, </span>y el tiempo de servicios se determinarán en función de los períodos efectivamente laborados, razón por la cual los períodos en que no exista prestación efectiva de labores por parte de <span class="ft3">EL TRABAJADOR, </span>serán considerados suspensión perfecta de labores.</p>
    <p class="p40 ft11"><span class="ft2">16.4</span><span class="ft24">Ambas partes declaran que durante la suspensión perfecta de labores EL TRABAJADOR no deberá asistir al centro de labores, ni realizará labores efectivas, por lo tanto EL EMPLEADOR no abonará remuneración alguna durante dicho período.</span></p>
    <p class="p41 ft2"><span class="ft2">16.5</span><span class="ft17">EL TRABAJADOR </span>entiende y conoce que la suspensión de labores no genera pago de remuneración durante el período de suspensión; asimismo, conoce y entiende que la suspensión del contrato de trabajo bajo ninguna circunstancia equivale a despido.</p>
    <p class="p30 ft3"><span class="ft1">DECIMO SETIMO</span>: Derecho de preferencia.-</p>
    <p class="p38 ft2"><span class="ft2">17.1</span><span class="ft18">Para la reanudación de las labores suspendidas </span><span class="ft3">EL EMPLEADOR </span>verificará que exista necesidad de recurso humano para el desarrollo de las labores descritas en la cláusula segunda; es decir, que el producto agrícola se encuentre en condiciones determinadas para continuar a la siguiente etapa o labor.</p>
    <p class="p42 ft2"><span class="ft2">17.2</span><span class="ft17">EL EMPLEADOR </span>respetará el derecho de preferencia de <span class="ft3">EL TRABAJADOR, </span>quien contará con un plazo máximo de cinco (5) días hábiles – contados desde la fecha señalada en el comunicado de suspensión- para hacer uso de su derecho de preferencia y proceda a reincorporarse a sus labores.</p>
    <p class="p43 ft2">En el supuesto que no se reincorpore dentro del período de cinco (5) días hábiles, <span class="ft3">EL CONTRATO </span>se resuelve de pleno derecho, quedando a salvo el derecho de <span class="ft3">EL TRABAJADOR </span>de solicitar la liquidación de sus beneficios sociales que le corresponda.</p>
    <p class="p30 ft3"><span class="ft1">DECIMO OCTAVO</span>: Condición resolutoria.-</p>
    <p class="p26 ft2"><span class="ft2">18.1</span><span class="ft18">En el supuesto que por lo factores señalados o por cualquier otra circunstancia, la prestación a cargo de </span><span class="ft3">EL TRABAJADOR </span>resulte innecesaria o imposible con anterioridad al vencimiento del contrato, <span class="ft3">EL EMPLEADOR </span>podrá resolver <span class="ft3">EL CONTRATO.</span></p>
    <p class="p24 ft2"><span class="ft2">18.2</span><span class="ft25">EL TRABAJADOR </span><span class="ft26">declara expresamente que conoce y entiende que la resolución de contrato no equivale a despido,</span> sino que la misma obedece a la imposibilidad de realizar las prestaciones para la cual fue contratado, o a la extinción de la necesidad que dio origen a la celebración de <span class="ft3">EL CONTRATO.</span></p>
    <p class="p30 ft3"><span class="ft1">DECIMO NOVENO</span>: Solución de Controversias.-</p>
    <p class="p35 ft2">Para todos los efectos emergentes de este contrato, las partes constituyen domicilio especial en los indicados en el encabezamiento del presente, donde serán válidas y surtirán plenos efectos todas las comunicaciones que deban cursarse con motivo del mismo. Asimismo, para cualquier discrepancia que se suscite entre las partes con motivo del presente, se pacta la jurisdicción y competencia de los Tribunales Ordinarios del Distrito Judicial de Piura.</p>
    <p class="p44 ft2">En señal de conformidad, las partes suscriben el presente documento por triplicado, en la ciudad de Piura, el <span class="ft3">03 de Junio del 2020</span><span class="ft27">.</span></p>
    <table cellpadding=0 cellspacing=0 class="t0">
    <tr>
        <td class="tr0 td0"><p class="p45 ft9">-------------------------------------------</p></td>
        <td class="tr0 td1"><p class="p46 ft2">----------------------------------------</p></td>
    </tr>
    <tr>
        <td class="tr1 td0"><p class="p47 ft3">EL EMPLEADOR</p></td>
        <td class="tr1 td1"><p class="p48 ft3">EL TRABAJADOR</p></td>
    </tr>
    </table>
    </div>
    <div id="page_4">


    </div>
    <div id="page_5">
    <div id="p5dimg1">
    <img src="data:image/jpg;base64,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AUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRTBNEZfKEimQDcUzyB64p9ABRRRQAUUUUAFFFFABRRRQAUUUUAFF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" id="p5img1"></div>


    <p class="p49 ft28">ANEXO 1</p>
    <p class="p50 ft30">El presente documento ha sido elaborado en virtud de lo establecido en el inciso c) del artículo 35° de la Ley N° 29783, Ley de Seguridad y Salud en el Trabajo, indicándose las funciones propias de <span class="ft29">OBRERO DE CAMPO, </span>a ser desarrolladas por EL TRABAJADOR.</p>
    <p class="p51 ft30">Igualmente se establecerán los posibles riesgos a los cuales puede encontrarse expuesto por</p>
    <p class="p52 ft30">la realización de dichas funciones y las recomendaciones referidas a las medidas de prevención destinadas a evitar los riesgos mencionados.</p>
    <table cellpadding=0 cellspacing=0 class="t1">
    <tr>
        <td class="tr2 td2"><p class="p53 ft31">Cargo o Puesto de Trabajo</p></td>
        <td class="tr2 td3"><p class="p54 ft31">OBRERO DE CAMPO</p></td>
    </tr>
    <tr>
        <td class="tr3 td4"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr3 td5"><p class="p55 ft32">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr1 td6"><p class="p53 ft33">Descripción de Funciones</p></td>
        <td class="tr1 td7"><p class="p54 ft34">Encargado de realizar las labores en los campos</p></td>
    </tr>
    <tr>
        <td class="tr3 td4"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr3 td5"><p class="p54 ft35">designados.</p></td>
    </tr>
    <tr>
        <td class="tr1 td6"><p class="p53 ft33">Riesgos Expuestos</p></td>
        <td class="tr1 td7"><p class="p56 ft34">Exposición a altas temperaturas</p></td>
    </tr>
    <tr>
        <td class="tr3 td6"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr3 td7"><p class="p56 ft35">Caída de personas a distinto nivel.</p></td>
    </tr>
    <tr>
        <td class="tr4 td6"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr4 td7"><p class="p56 ft36">Caída de personas al mismo nivel.</p></td>
    </tr>
    <tr>
        <td class="tr4 td6"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr4 td7"><p class="p56 ft36">Atropellos o golpes con vehículos:</p></td>
    </tr>
    <tr>
        <td class="tr3 td6"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr3 td7"><p class="p56 ft35">Choque contra objetos fijos.</p></td>
    </tr>
    <tr>
        <td class="tr4 td6"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr4 td7"><p class="p56 ft36">Golpes y cortes con objetos y herramientas.</p></td>
    </tr>
    <tr>
        <td class="tr3 td6"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr3 td7"><p class="p56 ft35">Atrapamiento por o entre objetos:</p></td>
    </tr>
    <tr>
        <td class="tr4 td6"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr4 td7"><p class="p56 ft36">Vuelco de máquinas o vehículos.</p></td>
    </tr>
    <tr>
        <td class="tr4 td6"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr4 td7"><p class="p56 ft36">Posturas prolongadas, movimientos repetitivos (riesgos</p></td>
    </tr>
    <tr>
        <td class="tr3 td6"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr3 td7"><p class="p56 ft35">disergonómicos)</p></td>
    </tr>
    <tr>
        <td class="tr4 td6"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr4 td7"><p class="p56 ft36">Sobreesfuerzos (riesgo disergonómico)</p></td>
    </tr>
    <tr>
        <td class="tr3 td4"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr3 td5"><p class="p56 ft35">Proyección de fragmentos o partículas.</p></td>
    </tr>
    <tr>
        <td class="tr1 td6"><p class="p53 ft33">Medidas de Prevención</p></td>
        <td class="tr1 td7"><p class="p56 ft34">Uso de ropa adecuada</p></td>
    </tr>
    <tr>
        <td class="tr3 td6"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr3 td7"><p class="p54 ft35">Señalización.</p></td>
    </tr>
    <tr>
        <td class="tr4 td6"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr4 td7"><p class="p56 ft36">Orden y limpieza.</p></td>
    </tr>
    <tr>
        <td class="tr4 td6"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr4 td7"><p class="p54 ft36">Capacitación de los trabajadores.</p></td>
    </tr>
    <tr>
        <td class="tr3 td6"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr3 td7"><p class="p56 ft35">Mantener distancias de seguridad.</p></td>
    </tr>
    <tr>
        <td class="tr4 td6"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr4 td7"><p class="p56 ft36">Cumplimiento de normas de manual de instrucciones,</p></td>
    </tr>
    <tr>
        <td class="tr3 td6"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr3 td7"><p class="p56 ft35">objetos punzantes de embalajes, piezas, etc.</p></td>
    </tr>
    <tr>
        <td class="tr4 td6"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr4 td7"><p class="p56 ft36">Adecuado uso y mantenimiento del equipo de protección</p></td>
    </tr>
    <tr>
        <td class="tr4 td6"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr4 td7"><p class="p56 ft36">personal.</p></td>
    </tr>
    <tr>
        <td class="tr3 td6"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr3 td7"><p class="p56 ft35">Diseño ergonómico del puesto de trabajo.</p></td>
    </tr>
    <tr>
        <td class="tr4 td6"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr4 td7"><p class="p56 ft36">Al levantar materiales, el Trabajador deberá doblar las</p></td>
    </tr>
    <tr>
        <td class="tr4 td6"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr4 td7"><p class="p56 ft36">rodillas y mantener la espalda lo más recta posible.</p></td>
    </tr>
    <tr>
        <td class="tr3 td6"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr3 td7"><p class="p56 ft37">Debe proveerse de lentes de seguridad, en todos aquellos</p></td>
    </tr>
    <tr>
        <td class="tr3 td4"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr3 td5"><p class="p56 ft35">trabajos donde esté presente dicho riesgo.</p></td>
    </tr>
    </table>
    <table cellpadding=0 cellspacing=0 class="t2">
    <tr>
        <td class="tr5 td8"><p class="p57 ft38">______________________</p></td>
        <td class="tr5 td9"><p class="p46 ft38">_______________________________</p></td>
    </tr>
    <tr>
        <td class="tr1 td8"><p class="p58 ft29">EL EMPLEADOR</p></td>
        <td class="tr1 td9"><p class="p59 ft29">RUFINO ALAMA LUIS</p></td>
    </tr>
    <tr>
        <td class="tr4 td8"><p class="p55 ft32">&nbsp;</p></td>
        <td class="tr4 td9"><p class="p60 ft38">DNI: 73273262</p></td>
    </tr>
    </table>
    </div>
    <div id="page_6">


    </div>
    <div id="page_7">
    <div id="p7dimg1">
    <img src="data:image/jpg;base64,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" id="p7img1"></div>


    <div class="dclr"></div>
    <p class="p61 ft39">Código de Conducta</p>
    <p class="p62 ft42">De acuerdo a la implementación de las normas internacionales <span class="ft40">(BSCI, SMETA, GRAPS, WALMART, WAITROSE, ETC</span>) que promueven los más altos estándares en responsabilidad laboral y social a nivel mundial, <span class="ft41">SOCIEDAD AGRÍCOLA RAPEL S.A.C. </span>(en adelante LA EMPRESA) rige su accionar de acuerdo a los siguientes criterios:</p>
    <p class="p33 ft41">1. Trabajo infantil</p>
    <p class="p63 ft42">LA EMPRESA prohíbe el trabajo infantil. En ese sentido, los trabajadores deben tener 18 años de edad como mínimo para ser contratados. Por trabajo infantil se entiende cualquier labor mental, física, social o moralmente peligrosa o dañina para los niños, o que interfiere directamente en sus necesidades de educación obligatoria definida como tal por la autoridad correspondiente.</p>
    <p class="p64 ft41">2. Trabajo de libre elección y no forzoso</p>
    <p class="p63 ft43">La mano de obra ilegal, abusiva o forzosa no tiene cabida en las actividades de LA EMPRESA ni en las actividades de nuestros proveedores. En ese sentido,</p>
    <p class="p65 ft42">LA EMPRESA no impondrá el trabajo sino que será de libre elección por parte del trabajador. Se prohíbe cualquier tipo de servidumbre esclavizante o forma alguna de realizar el trabajo de manera involuntaria.</p>
    <p class="p63 ft42">LA EMPRESA no exigirá depósitos ni retendrá documentos originales de identidad como condición de trabajo. Asimismo, no subcontratará proveedores o instalaciones de producción que obliguen que el trabajo sea realizado bajo algún tipo de explotación o trabajo forzado.</p>
    <p class="p64 ft41">3. Seguridad y salud en el trabajo</p>
    <p class="p63 ft43">LA EMPRESA proporciona un lugar de trabajo seguro, higiénico y saludable, tomando así las medidas necesarias para prevenir accidentes y lesiones que surjan en el desarrollo del trabajo, se relacionen con él, o que ocurran como resultado de las operaciones de la empresa. LA EMPRESA tiene sistemas para detectar, evitar y responder a posibles riesgos de la seguridad y la salud de todos sus colaboradores. Asimismo, LA EMPRESA brindará acceso a agua potable, zonas limpias y seguras para almacenamiento de comidas, cumpliendo las necesidades básicas de los trabajadores.</p>
    <p class="p66 ft42">El trabajador podrá negarse a cualquier tipo de trabajo inseguro o que ponga en riesgo su vida. Los trabajadores serán informados de manera regular sobre la seguridad e higiene, ya sean nuevos o reasignados, otorgando la responsabilidad a un representante del Comité de Seguridad y Salud en el Trabajo.</p>
    <p class="p33 ft41">4. Libertad de asociación y negociación colectiva</p>
    <p class="p63 ft42">LA EMPRESA respeta el derecho a formar comités según interés y/o unirse a comités creados por la empresa, además de las decisiones de sus colaboradores, asimismo, facilitará el tiempo necesario para entablar discusiones, encontrar soluciones, y llegar a acuerdos conjuntamente con administración sobre: seguridad, salud, bienestar y demás conflictos colectivos de todos los trabajadores. El empleador y sus representantes velarán por las mejores condiciones y seguridad para sus trabajadores, mostrando una actitud tolerante hacia sus distintas actividades. Los representantes de los trabajadores no serán discriminados y tendrán acceso a desarrollar sus funciones representativas en el lugar de trabajo. El empleador continuará facilitando, sin dificultad alguna, el desarrollo de las actividades, en caso la ley restrinja el derecho de la libertad de asociación y a la negociación colectiva.</p>
    <p class="p33 ft41">5. Discriminación</p>
    <p class="p63 ft42">LA EMPRESA prohíbe las prácticas de discriminación en la contratación de personal y en la conducta profesional del mismo por cuestiones de raza, color, religión, sexo, edad, capacidades físicas, nacionalidades o cualquier otra condición prohibida legalmente.</p>
    <p class="p64 ft41">6. Protección especial para trabajadores jóvenes</p>
    <p class="p63 ft42">LA EMPRESA promueve la contratación de jóvenes entre 18 a 24 años, para que cuenten con mayores oportunidades de acceso al mercado laboral a través de un empleo con calidad y protección social.</p>
    <p class="p33 ft41">7. Horario de trabajo no excesivo</p>
    <p class="p63 ft42">LA EMPRESA es responsable de asegurar que sus colaboradores trabajen dentro de la jornada máxima permitida por la normatividad laboral vigente y los estándares laborales referentes al número de horas y días de trabajo. En caso de conflicto entre un estatuto y un estándar industrial mandatorio, LA EMPRESA deberá dar solución bajo lo establecido en función al que brinde un mayor beneficio para el trabajador. Las horas extras serán de manera voluntaria y, además, debe de existir un convenio colectivo negociado libremente o en circunstancias excepcionales donde el empleador demuestre que surgieron de manera inesperada. Se debe otorgar al personal por lo menos un día libre a continuación de cada período consecutivo de seis días laborados.</p>
    <p class="p33 ft41">8. Remuneración digna</p>
    <p class="p63 ft42">LA EMPRESA deberá proporcionar a sus colaboradores salarios y beneficios que cumplan al menos con las leyes aplicables, en caso contrario, salarios que cubran las necesidades básicas, incluyendo aquellos referentes al pago por horas extras. LA EMPRESA informará de manera escrita y comprensible antes de que acepten el trabajo, los diversos detalles durante el periodo de su pago, así como también, las deducciones al salario que serán aplicables según ley, las cuales deberán ser registradas.</p>
    <p class="p33 ft41">9. Trabajo precario</p>
    <p class="p63 ft42">LA EMPRESA proporciona a sus trabajadores información clara sobre sus derechos, responsabilidades, condiciones laborales y condiciones de trabajo dignas.</p>
    <p class="p64 ft41">10. Medio ambiente</p>
    <p class="p63 ft42">LA EMPRESA realiza sus operaciones en cumplimiento de las normativas aplicables y de sus compromisos ambientales que incluyen monitoreo de emisiones, manejo de aguas residuales, ruido ambiental, residuos sólidos, entre otros; mitigando de esta manera sus impactos ambientales y esforzándose por mejorar continuamente su desempeño ambiental.</p>
    <p class="p33 ft41">11. Comportamiento empresarial ético</p>
    <p class="p63 ft42">LA EMPRESA se asegurará de que sus proveedores estén informados de este Código de Conducta, de sus términos y condiciones, así como de su significado y lo que implica su implementación.</p>
    <p class="p64 ft42">Declaro por tanto haber recibido una copia de código de conducta, así también, declaro haberlo leído cuidadosamente.</p>
    <p class="p67 ft44">____________________________________________</p>
    <p class="p6 ft45">Nombre: RUFINO ALAMA LUIS</p>
    <p class="p15 ft45">D.N.I: 73273262</p>
    <p class="p6 ft45">Cargo: OBRERO DE CAMPO</p>
    <p class="p68 ft46">El Papayo, 03 de Junio del 2020</p>
    </div>
    <div id="page_8">


    </div>
    <div id="page_9">
    <div id="p9dimg1">
    <img src="data:image/jpg;base64,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1z/we3v/AMeroKKAOf8A+EN0v/n61z/we3v/AMeo/wCEN0v/AJ+tc/8AB7e//Hq6CigDn/8AhDdL/wCfrXP/AAe3v/x6j/hDdL/5+tc/8Ht7/wDHq6CigDn/APhDdL/5+tc/8Ht7/wDHqP8AhDdL/wCfrXP/AAe3v/x6ugooA5//AIQ3S/8An61z/wAHt7/8eo/4Q3S/+frXP/B7e/8Ax6ugooA5/wD4Q3S/+frXP/B7e/8Ax6j/AIQ3S/8An61z/wAHt7/8eroKKAOf/wCEN0v/AJ+tc/8AB7e//HqP+EN0v/n61z/we3v/AMeroKKAOf8A+EN0v/n61z/we3v/AMeo/wCEN0v/AJ+tc/8AB7e//Hq6CigDn/8AhDdL/wCfrXP/AAe3v/x6j/hDdL/5+tc/8Ht7/wDHq6CigDn/APhDdL/5+tc/8Ht7/wDHqP8AhDdL/wCfrXP/AAe3v/x6ugooA5//AIQ3S/8An61z/wAHt7/8eoroKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAorn/wDhDdL/AOfrXP8Awe3v/wAeo/4Q3S/+frXP/B7e/wDx6gDoKK5//hDdL/5+tc/8Ht7/APHqP+EN0v8A5+tc/wDB7e//AB6gDoKK5/8A4Q3S/wDn61z/AMHt7/8AHqP+EN0v/n61z/we3v8A8eoA6Ciuf/4Q3S/+frXP/B7e/wDx6j/hDdL/AOfrXP8Awe3v/wAeoA6Ciuf/AOEN0v8A5+tc/wDB7e//AB6j/hDdL/5+tc/8Ht7/APHqAOgorn/+EN0v/n61z/we3v8A8eo/4Q3S/wDn61z/AMHt7/8AHqAOgorn/wDhDdL/AOfrXP8Awe3v/wAeo/4Q3S/+frXP/B7e/wDx6gDoKK5//hDdL/5+tc/8Ht7/APHqP+EN0v8A5+tc/wDB7e//AB6gDoKK5/8A4Q3S/wDn61z/AMHt7/8AHqP+EN0v/n61z/we3v8A8eoA6Ciuf/4Q3S/+frXP/B7e/wDx6j/hDdL/AOfrXP8Awe3v/wAeoA6Ciuf/AOEN0v8A5+tc/wDB7e//AB6j/hDdL/5+tc/8Ht7/APHqAOgorn/+EN0v/n61z/we3v8A8eo/4Q3S/wDn61z/AMHt7/8AHqAOgorn/wDhDdL/AOfrXP8Awe3v/wAeo/4Q3S/+frXP/B7e/wDx6gDoKK5//hDdL/5+tc/8Ht7/APHqP+EN0v8A5+tc/wDB7e//AB6gDoKK5/8A4Q3S/wDn61z/AMHt7/8AHqP+EN0v/n61z/we3v8A8eoA6Ciuf/4Q3S/+frXP/B7e/wDx6j/hDdL/AOfrXP8Awe3v/wAeoA6Ciuf/AOEN0v8A5+tc/wDB7e//AB6j/hDdL/5+tc/8Ht7/APHqAOgorn/+EN0v/n61z/we3v8A8eo/4Q3S/wDn61z/AMHt7/8AHqAOgorn/wDhDdL/AOfrXP8Awe3v/wAeo/4Q3S/+frXP/B7e/wDx6gDoKK5//hDdL/5+tc/8Ht7/APHqP+EN0v8A5+tc/wDB7e//AB6gDoKK5/8A4Q3S/wDn61z/AMHt7/8AHqP+EN0v/n61z/we3v8A8eoA6Ciuf/4Q3S/+frXP/B7e/wDx6j/hDdL/AOfrXP8Awe3v/wAeoA6Ciuf/AOEN0v8A5+tc/wDB7e//AB6j/hDdL/5+tc/8Ht7/APHqAOgorn/+EN0v/n61z/we3v8A8eo/4Q3S/wDn61z/AMHt7/8AHqAOgorn/wDhDdL/AOfrXP8Awe3v/wAeo/4Q3S/+frXP/B7e/wDx6gDoKK5//hDdL/5+tc/8Ht7/APHqP+EN0v8A5+tc/wDB7e//AB6gDoKK5/8A4Q3S/wDn61z/AMHt7/8AHqP+EN0v/n61z/we3v8A8eoA6Ciuf/4Q3S/+frXP/B7e/wDx6j/hDdL/AOfrXP8Awe3v/wAeoA6Ciuf/AOEN0v8A5+tc/wDB7e//AB6j/hDdL/5+tc/8Ht7/APHqAOgorn/+EN0v/n61z/we3v8A8eo/4Q3S/wDn61z/AMHt7/8AHqAOgorn/wDhDdL/AOfrXP8Awe3v/wAeo/4Q3S/+frXP/B7e/wDx6gDoKK5//hDdL/5+tc/8Ht7/APHqP+EN0v8A5+tc/wDB7e//AB6gDoKK5/8A4Q3S/wDn61z/AMHt7/8AHqP+EN0v/n61z/we3v8A8eoA6Ciuf/4Q3S/+frXP/B7e/wDx6j/hDdL/AOfrXP8Awe3v/wAeoA6Ciuf/AOEN0v8A5+tc/wDB7e//AB6j/hDdL/5+tc/8Ht7/APHqAOgorn/+EN0v/n61z/we3v8A8eo/4Q3S/wDn61z/AMHt7/8AHqAOgorn/wDhDdL/AOfrXP8Awe3v/wAeo/4Q3S/+frXP/B7e/wDx6gDoKK5//hDdL/5+tc/8Ht7/APHqP+EN0v8A5+tc/wDB7e//AB6gDoKK5/8A4Q3S/wDn61z/AMHt7/8AHqP+EN0v/n61z/we3v8A8eoA6Ciuf/4Q3S/+frXP/B7e/wDx6j/hDdL/AOfrXP8Awe3v/wAeoA6Ciuf/AOEN0v8A5+tc/wDB7e//AB6igDoKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiii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" id="p9img1"></div>


    <div class="dclr"></div>
    <p class="p69 ft47">DECLARACIÓN JURADA DE NO TENER ANTECEDENTES POLICIALES, PENALES NI</p>
    <p class="p70 ft47">JUDICIALES</p>
    <p class="p71 ft49">YO, <span class="ft48">RUFINO ALAMA LUIS </span>IDENTIFICADO(A) CON DNI Nº <span class="ft48">73273262 </span>CON DOMICILIO REAL EN <span class="ft48">MZ. X LT.</span></p>
    <p class="p72 ft51">185 CASERIO SANTA ANA - TAMBO GRANDE <span class="ft50">DEL DISTRITO DE </span>TAMBO GRANDE<span class="ft50">, PROVINCIA </span>PIURA <span class="ft50">Y DEPARTAMENTO </span>PIURA<span class="ft50">, AL AMPARO DE LO PREVISTO EN EL ARTÍCULO 41° DE LA LEY N° 27444, LEY DEL PROCEDIMIENTO ADMINISTRATIVO GENERAL, EN APLICACIÓN DEL PRINCIPIO DE PRESUNCIÓN DE LA VERACIDAD; DECLARO BAJO JURAMENTO:</span></p>
    <p class="p73 ft49"><span class="ft52">1.</span><span class="ft53">NO REGISTRAR ANTECEDENTES POLICIALES.</span></p>
    <p class="p74 ft49"><span class="ft52">2.</span><span class="ft53">NO REGISTRAR ANTECEDENTES JUDICIALES.</span></p>
    <p class="p74 ft49"><span class="ft52">3.</span><span class="ft53">NO REGISTRAR ANTECEDENTES PENALES.</span></p>
    <p class="p75 ft50">QUIEN SUSCRIBE ENTIENDE QUE LA INFORMACIÓN CONSIGNADA ES VERAZ Y FIDEDIGNA, POR LA CUAL AUTORIZÓ A LA EMPRESA A EFECTUAR LAS VERIFICACIONES QUE JUZGUE NECESARIAS EN CUALQUIER MOMENTO DE LA RELACIÓN LABORAL.</p>
    <p class="p76 ft50">EN EL SUPUESTO SE CONSTANTE LA FALSEDAD DE LA INFORMACIÓN QUE HE PROPORCIONADO, QUIEN SUSCRIBE SERÁ PASIBLE DE LAS SANCIONES QUE LA EMPRESA ESTIME CONVENIENTE Y LA EMPRESA PODRÁ TOMAR LAS ACCIONES LEGALES CORRESPONDIENTES.</p>
    <p class="p77 ft49">EN FE DE LO CUAL FIRMO Y PONGO MI IMPRESIÓN DIGITAL.</p>
    <p class="p78 ft48">Piura, 03 de Junio del 2020.</p>
    <table cellpadding=0 cellspacing=0 class="t3">
    <tr>
        <td rowspan=2 class="tr6 td10"><p class="p79 ft45">HUELLA DIGITAL</p></td>
        <td class="tr1 td11"><p class="p80 ft48">FIRMA DEL TRABAJADOR</p></td>
    </tr>
    <tr>
        <td class="tr7 td12"><p class="p55 ft54">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr6 td10"><p class="p55 ft45">(INDICE DERECHO)</p></td>
        <td class="tr6 td12"><p class="p81 ft48">DNI/CE: 73273262</p></td>
    </tr>
    </table>
    </div>
    <div id="page_10">


    </div>
    <div id="page_11">
    <div id="p11dimg1">
    <img src="data:image/jpg;base64,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" id="p11img1"></div>


    <p class="p82 ft55">CONVENIO DE AUTORIZACIÓN PARA LA TRAMITACIÓN DE ANTECEDENTES POLICIALES</p>
    <p class="p83 ft49">Conste por el presente documento, el CONVENIO DE AUTORIZACIÓN PARA LA TRAMITACIÓN DE ANTECEDENTES POLICIALES (en adelante “<span class="ft48">EL CONVENIO</span>”) que suscriben de una parte <span class="ft48">SOCIEDAD AGRICOLA RAPEL SAC</span>, identificado con RUC Nº 20451779711, inscrita en la Partida Electrónica N° 12619278, del Registro de Personas Jurídicas de Lima, con domicilio en Caserío el Papayo Mz O, Distrito de Castilla, debidamente representada por el Jefe de Recursos Humanos, Carrillo Curay Federico, identificado con D.N.I N° 44554215, a quien en lo sucesivo se denominará <span class="ft48">EL EMPLEADOR</span>, y de la otra parte <span class="ft48">RUFINO ALAMA LUIS</span>, identificado (a) con D.N.I. N° <span class="ft48">73273262</span>, con domicilio en <span class="ft48">MZ. X LT. 185 CASERIO SANTA ANA - TAMBO GRANDE</span>, a quien en adelante se le denominará <span class="ft48">EL TRABAJADOR, </span>en los términos y condiciones siguientes:</p>
    <p class="p10 ft48"><span class="ft55">PRIMERO</span>: ANTECEDENTES</p>
    <p class="p84 ft49"><span class="ft48">EL EMPLEADOR </span>dentro de su Política de Contratación, en el artículo 2° establece los requisitos aplicables todos los trabajadores sin distinción del cargo que ocupan y la naturaleza de sus funciones. Superado el proceso de selección <span class="ft48">EL EMPLEADOR, </span>conforme lo dispuesto en la Ley 29607, exige a <span class="ft48">EL TRABAJADOR </span>la presentación del certificado de antecedentes policiales.</p>
    <p class="p10 ft48"><span class="ft55">SEGUNDO</span>: OBJETO DEL CONVENIO</p>
    <p class="p85 ft49"><span class="ft48">EL EMPLEADOR </span>con la finalidad de otorgar facilidades suscribe el presente convenio, mediante el cual <span class="ft48">EL TRABAJADOR </span>autoriza expresamente a <span class="ft48">EL EMPLEADOR </span>la tramitación y obtención del certificado de antecedentes policiales.</p>
    <p class="p23 ft48"><span class="ft55">TERCERO</span>: DEL COSTO DE LOS CERTIFICADOS</p>
    <p class="p19 ft49"><span class="ft48">EL TRABAJADOR </span>será quien asuma el costo de los certificados de antecedentes policiales, siendo el importe de S/.</p>
    <p class="p86 ft49"><span class="ft49">11.00</span><span class="ft56">(ONCE CON 00/100 SOLES), el cual será descontado de su remuneración en una (1) sola cuota, en el mes de </span><span class="ft52">JUNIO </span><span class="ft48">- 2020</span>.</p>
    <p class="p83 ft49"><span class="ft48">EL TRABAJADOR </span>conoce y entiende que en el supuesto que se compruebe que mantiene deuda por el trámite de antecedentes policiales, el costo será descontado del pago por los días efectivamente laborados o de la liquidación de beneficios sociales respectiva o, por lo cual <span class="ft48">EL TRABAJADOR </span>deja expresa constancia que autoriza a <span class="ft48">EL EMPLEADOR </span>a realizar el descuento que corresponda.</p>
    <p class="p10 ft48"><span class="ft55">CUARTO</span>:</p>
    <p class="p84 ft49">En todo lo no previsto en el presente Convenio, que se mantiene como documento privado, es aplicable la legislación laboral vigente.</p>
    <p class="p10 ft49">En señal de conformidad, suscriben el presente documento las partes, en Piura, al <span class="ft57">03 de Junio del 2020</span><span class="ft48">.</span></p>
    <table cellpadding=0 cellspacing=0 class="t4">
    <tr>
        <td class="tr4 td13"><p class="p87 ft49">_________________________</p></td>
        <td class="tr4 td14"><p class="p46 ft49">_______________________</p></td>
    </tr>
    <tr>
        <td class="tr8 td13"><p class="p88 ft48">EL EMPLEADOR</p></td>
        <td class="tr8 td14"><p class="p89 ft48">EL TRABAJADOR</p></td>
    </tr>
    </table>
    </div>
    <div id="page_12">


    </div>
    <div id="page_13">
    <div id="p13dimg1">
    <img src="data:image/jpg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAJjAccDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD3+iiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAbIgkjaNiwDAglWKnn0I5H1FUf7Gtf+et9/wCB8/8A8XWhRQBn/wBjWv8Az1vv/A+f/wCLo/sa1/5633/gfP8A/F1oUUAZ/wDY1r/z1vv/AAPn/wDi6P7Gtf8Anrff+B8//wAXWhRQBn/2Na/89b7/AMD5/wD4uj+xrX/nrff+B8//AMXWhRQBn/2Na/8APW+/8D5//i6P7Gtf+et9/wCB8/8A8XWhRQBn/wBjWv8Az1vv/A+f/wCLo/sa1/5633/gfP8A/F1oUUAZ/wDY1r/z1vv/AAPn/wDi6P7Gtf8Anrff+B8//wAXWhRQBn/2Na/89b7/AMD5/wD4uj+xrX/nrff+B8//AMXWhRQBXtbKK03+W87bsZ82d5OnpuJx+FWKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA5//hDdL/5+tc/8Ht7/APHqP+EN0v8A5+tc/wDB7e//AB6ugooA5/8A4Q3S/wDn61z/AMHt7/8AHqP+EN0v/n61z/we3v8A8eroKKAOf/4Q3S/+frXP/B7e/wDx6j/hDdL/AOfrXP8Awe3v/wAeroKKAOf/AOEN0v8A5+tc/wDB7e//AB6j/hDdL/5+tc/8Ht7/APHq6CigDn/+EN0v/n61z/we3v8A8eo/4Q3S/wDn61z/AMHt7/8AHq6CigDn/wDhDdL/AOfrXP8Awe3v/wAeo/4Q3S/+frXP/B7e/wDx6ugooA5//hDdL/5+tc/8Ht7/APHqP+EN0v8A5+tc/wDB7e//AB6ugooA5/8A4Q3S/wDn61z/AMHt7/8AHqP+EN0v/n61z/we3v8A8eroKKAOf/4Q3S/+frXP/B7e/wDx6j/hDdL/AOfrXP8Awe3v/wAeroKKAOf/AOEN0v8A5+tc/wDB7e//AB6j/hDdL/5+tc/8Ht7/APHq6CigDn/+EN0v/n61z/we3v8A8eo/4Q3S/wDn61z/AMHt7/8AHq6CigDn/wDhDdL/AOfrXP8Awe3v/wAeo/4Q3S/+frXP/B7e/wDx6ugooA5//hDd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" id="p13img1"></div>


    <p class="p90 ft58">CONSTANCIA DE ENTREGA DE</p>
    <p class="p91 ft58">REGLAMENTO INTERNO DE TRAB<span class="ft39">AJO</span></p>
    <table cellpadding=0 cellspacing=0 class="t5">
    <tr>
        <td colspan=2 class="tr1 td15"><p class="p55 ft48"><span class="ft44">Yo, </span>RUFINO ALAMA,</p></td>
        <td class="tr1 td16"><p class="p92 ft48">LUIS</p></td>
        <td class="tr1 td17"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr1 td18"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr9 td19"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr9 td20"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr9 td21"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr9 td22"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr9 td18"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td colspan=2 class="tr10 td15"><p class="p55 ft44">Identificado con D.N.I N°</p></td>
        <td class="tr10 td16"><p class="p87 ft48">73273262</p></td>
        <td colspan=2 class="tr10 td23"><p class="p55 ft42">, manifiesto haber</p></td>
    </tr>
    </table>
    <p class="p93 ft44">recibido un ejemplar del Reglamento Interno de Trabajo, comprometiéndome a leerlo, estudiarlo y cumplirlo, durante la vigencia del vínculo laboral que mantengo con La Empresa.</p>
    <p class="p94 ft44">Me comprometo voluntariamente a difundir y velar por su cumplimiento entre mis compañeros de trabajo.</p>
    <p class="p95 ft45">Piura, 03 de Junio del 2020.</p>
    <table cellpadding=0 cellspacing=0 class="t6">
    <tr>
        <td rowspan=2 class="tr11 td24"><p class="p96 ft40">________________________________________</p></td>
        <td class="tr12 td25"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr7 td26"><p class="p55 ft54">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr13 td24"><p class="p97 ft45">FIRMA</p></td>
        <td class="tr13 td26"><p class="p98 ft45">HUELLA</p></td>
    </tr>
    <tr>
        <td class="tr0 td24"><p class="p99 ft45">DNI: 73273262</p></td>
        <td class="tr0 td26"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    </table>
    <table cellpadding=0 cellspacing=0 class="t7">
    <tr>
        <td class="tr10 td27"><p class="p55 ft60">Prohibida la reproducción total o parcial de este documento</p></td>
        <td class="tr10 td28"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr0 td27"><p class="p55 ft60">sin autorización de SOCIEDAD AGRICOLA RAPEL S.A.C.</p></td>
        <td class="tr0 td28"><p class="p46 ft61">73</p></td>
    </tr>
    </table>
    </div>
    <div id="page_14">


    </div>
    <div id="page_15">
    <div id="p15dimg1">
    <img src="data:image/jpg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAJmA+MDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD3+sjWvFGh+HU3atqUFsxAYRk7pGBOMhBliM9wKpeN/EFx4c0EXNoiNPNMIUZ+QmQTux34U8e/fGDg/DrxXeatcT6XeRxkxxGaOSOMIAAQCpC4H8Qxx2NZe1gpqD3OyGBrTw7xK+FfeTr471jWRnwx4SvrqFlyt3fMtvEQTwy5++PoQfarMVr8Q7zi71LQtOXs1pbyTN+Icgfka7Kit+ZdEcZysGi+MoZN7+MLWcf3JNIUA/8AfMgNK+p+LtKVpL7RrPVbcMSX0uUxyqgGc+VJ949sB8mupopc3dAY2i+KdJ153gtZ2jvYhmayuEMU8XTO5DzxkcjI561s1ma54e0rxHZ/ZdVs0uIwcoTkMh9VYcjoOnXvSaNpl5pUTW02qz6hbqFELXSgzLgYIZxgOOnVc9ck8YHboBqUUUUgCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAoorm/G/iC48OaCLm0RGnmmEKM/ITIJ3Y78KePfvjBmclFczNKNKVaoqcN2Xda8UaH4dTdq2pQWzEBhGTukYE4yEGWIz3Arm18d6xrIz4Y8JX11Cy5W7vmW3iIJ4Zc/fH0IPtUHw68V3mrXE+l3kcZMcRmjkjjCAAEAqQuB/EMcdjXoVOnUhKPMkaYnDTw1R0qm5xsVr8Q7zi71LQtOXs1pbyTN+IcgfkasQaL4yhk3v4wtZx/ck0hQD/3zIDXVUVfO+xznLPqfi7SlaS+0az1W3DEl9LlMcqoBnPlSfePbAfJrQ0XxTpOvO8FrO0d7EMzWVwhini6Z3IeeMjkZHPWtmszXPD2leI7P7LqtmlxGDlCchkPqrDkdB0696V090Bp0Vl6Npl5pUTW02qz6hbqFELXSgzLgYIZxgOOnVc9ck8Y1KXUAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA8x+IPi3WbPxLB4b03SLHUkurUS+TPA8jM2XzgBh0CZ6Z4rC0Tx1f+Dr+C213wtBpVldHDTQwSI+AfvZYsXC7umcjPvg2fHl3qlj8YNJudFtEu9RSw/cwuCQ2fODcAjopJ69qxxf6/8AFbXbbQ9VNnp0VnIzzxopjk9GG1ySWGCMY4yc9q6I04NJtLbfqUqk1HkTdu3Q96orz74i2kEl5YS6v4qfStE2OstpAxWWY/3lADb8Hy+Cp2jJzzWB8LNYZ/G2q6RZareX+irbNJbNdE5G11AIB+7985wBnAJA6DJU7x5iT2CivJfCGiah4u0O7kvdb1BIopNsAWYsPN2gksD1AymACO/So7TxnqMHgG+gluJ2v0uVt0uGcl0WQM33s5yNjgHtkelcaxCtdqyZ60sqlzunCack0no9L9f8z16uavfE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UUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUU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" id="p15img1"></div>


    <div class="dclr"></div>
    <div>
    <div id="id15_1">
    <p class="p100 ft62">REGLAMENTO INTERNO DE SEGURIDAD Y SALUD EN EL TRABAJO</p>
    <p class="p101 ft41">DECLARACIÓN DE ACEPTACIÓN DEL REGLAMENTO INTERNO DE SEGURIDAD Y</p>
    <p class="p102 ft41">SALUD EN EL TRABAJO</p>
    <p class="p103 ft42">Yo, <span class="ft41">RUFINO ALAMA LUIS</span>, identificado con DNI N° <span class="ft41">73273262</span>, desempeñándome en el cargo de <span class="ft41">OBRERO DE CAMPO</span>, declaro que desarrollare mis labores en forma segura, comprometiéndome a cumplir y acatar todas las normativas y procedimientos de Seguridad y Salud en el Trabajo establecidas por la Empresa en el presente Reglamento y demás directivas o políticas internas; siendo esto condición imprescindible para mi permanencia en la Empresa.</p>
    <p class="p104 ft42">Asimismo, declaro que me regiré por los procedimientos mencionados de Seguridad y Salud en el Trabajo y las normas que sobre el tema se han dictado y se dicten en adelante; adecuando mi desempeño laboral a una conducta segura e higiénica, y de respeto hacia mis compañeros de trabajo, jefes, clientes, comunidad y medio ambiente. Cualquier incumplimiento de las normas y procedimientos establecidos en SOCIEDAD AGRICOLA RAPEL S.A.C., me obligará a someterme a las sanciones establecidas en el Reglamento Interno de Seguridad y Salud en el Trabajo, y demás normas internas de la Empresa., las cuales conozco y acato en su totalidad.</p>
    <p class="p105 ft63">Finalmente, declaro haber recibido un ejemplar del Reglamento Interno de Seguridad y Salud en el Trabajo, así también declaro haberlo leído cuidadosamente y me comprometo a darle estricto cumplimiento.</p>
    <p class="p106 ft42">Dejo presente que dicho ejemplar me fue entregado en forma gratuita.</p>
    <p class="p107 ft41">El Papayo, 03 de Junio del 2020</p>
    <table cellpadding=0 cellspacing=0 class="t8">
    <tr>
        <td class="tr6 td29"><p class="p108 ft42">__________________________</p></td>
        <td class="tr6 td30"><p class="p109 ft64">Huella</p></td>
    </tr>
    </table>
    <p class="p110 ft41">FIRMA DEL(A) TRABAJADOR (A)</p>
    </div>
    <div id="id15_2">
    <p class="p111 ft62">REGLAMENTO INTERNO DE SEGURIDAD Y SALUD EN EL TRABAJO</p>
    <p class="p112 ft41">RADIACION ULTRAVIOLETA</p>
    <p class="p113 ft42">Yo, <span class="ft41">RUFINO ALAMA LUIS</span>, identificado con DNI N° <span class="ft41">73273262</span>, desempeñándome en el cargo de <span class="ft41">OBRERO DE CAMPO</span>, declaro haber recibido instrucción e información sobre la Guía para el cumplimiento legal de la Ley Nº 30102, “LEY QUE DISPONE MEDIDAS PREVENTIVAS CONTRA LOS EFECTOS NOCIVOS PARA LA SALUD POR LA EXPOSICIÓN PROLONGADA A LA RADIACIÓN SOLAR”, indicándome los riesgos específicos de exposición laboral a radiación UV de origen solar y sus medidas de control en los siguientes términos: “la exposición excesiva y/o acumulada de radiación ultravioleta produce efectos dañinos a corto y largo plazo, principalmente en ojos y piel que van desde quemaduras solares, queratitis actínica y alteraciones de la respuesta inmune hasta foto envejecimiento, tumores malignos de piel y cataratas a nivel ocular”, en los siguientes términos:</p>
    <p class="p114 ft42"><span class="ft42">1.</span><span class="ft65">Efectos en la salud por exposición a radiación UV.</span></p>
    <p class="p115 ft42"><span class="ft42">2.</span><span class="ft65">Expuestos y puestos de trabajo en riesgo dentro de la empresa.</span></p>
    <p class="p116 ft42"><span class="ft42">3.</span><span class="ft65">Medidas de control y de protección personal.</span></p>
    <p class="p117 ft67"><span class="ft42">4.</span><span class="ft66">Concientización sobre la correcta utilización y cuidados de los elementos de protección personal</span></p>
    <p class="p118 ft41">El Papayo, 03 de Junio del 2020</p>
    <table cellpadding=0 cellspacing=0 class="t9">
    <tr>
        <td class="tr5 td31"><p class="p119 ft42">__________________________</p></td>
        <td class="tr5 td32"><p class="p120 ft64">Huella</p></td>
    </tr>
    </table>
    <p class="p121 ft41">FIRMA DEL(A) TRABAJADOR (A)</p>
    </div>
    </div>
    </div>
    <div id="page_16">


    </div>
    <div id="page_17">
    <div id="p17dimg1">
    <img src="data:image/jpg;base64,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0bw/cW+oW7QStdM4ViDldiDPB9QakuPHVnBLqCCNDHAsD2lwZ1EV4sg5dW/uJ1dhnCgntiujsLyPULCC7hZSkyBxtYMB6jI64PFWqPLZv+rmNXGyqRlGySlbvpy3t+etyxRRRWhxhRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFAH//Z" id="p17img1"></div>


    <div class="dclr"></div>
    <div>
    <div id="id17_1">
    <p class="p122 ft62">REGLAMENTO INTERNO DE SEGURIDAD Y SALUD EN EL TRABAJO</p>
    <p class="p123 ft68">POLÍTICA DE SEGURIDAD Y SALUD EN EL TRABAJO</p>
    <p class="p124 ft69">SOCIEDAD AGRÍCOLA RAPEL SAC; empresa dedicada al cultivo, procesamiento y comercialización de uva de mesa, reconoce que el capital humano constituye lo más importante para la organización, por tal motivo se compromete a:</p>
    <p class="p125 ft70"><span class="ft70">1.</span><span class="ft71">Proteger la integridad y la salud de todos los trabajadores, proveedores, clientes y visitantes que laboren o ingresen en cualquiera de nuestras instalaciones; ejecutando los planes, programas y medidas de prevención destinadas a prevenir accidentes y enfermedades ocupacionales.</span></p>
    <p class="p126 ft70"><span class="ft70">2.</span><span class="ft71">Promover una cultura preventiva, basada en la identificación de los peligros y evaluación los riesgos determinando las medidas de control orientadas a eliminar o minimizar los impactos a la seguridad y salud de nuestros colaboradores.</span></p>
    <p class="p127 ft70"><span class="ft70">3.</span><span class="ft71">Cumplir las normas legales, las normas técnicas de adhesión voluntaria, convenios de negociación colectiva y otros requisitos relativos a la seguridad y salud en el trabajo suscritos por nuestra empresa.</span></p>
    <p class="p126 ft70"><span class="ft70">4.</span><span class="ft71">Garantizar la comunicación y consulta a los trabajadores y sus representantes, así como su capacitación, información y participación activa en el Sistema de Gestión de Seguridad y Salud en el Trabajo de acuerdo a lo estipulado en la legislación nacional.</span></p>
    <p class="p128 ft69"><span class="ft69">5.</span><span class="ft72">Implementar y mejorar continuamente el Sistema de Gestión de Seguridad y Salud en el Trabajo e integrarlo a los demás sistemas desarrollados en la Empresa.</span></p>
    <table cellpadding=0 cellspacing=0 class="t10">
    <tr>
        <td class="tr14 td33"><p class="p53 ft70">Nombres:</p></td>
        <td class="tr14 td34"><p class="p56 ft70">LUIS</p></td>
    </tr>
    <tr>
        <td class="tr4 td35"><p class="p53 ft70">Apellidos:</p></td>
        <td rowspan=2 class="tr8 td36"><p class="p56 ft70">RUFINO ALAMA</p></td>
    </tr>
    <tr>
        <td class="tr15 td37"><p class="p55 ft73">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr4 td35"><p class="p53 ft70">Cargo:</p></td>
        <td rowspan=2 class="tr16 td36"><p class="p56 ft42">OBRERO DE CAMPO</p></td>
    </tr>
    <tr>
        <td class="tr17 td37"><p class="p55 ft74">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr4 td35"><p class="p53 ft70">DNI N°:</p></td>
        <td rowspan=2 class="tr8 td36"><p class="p56 ft70">73273262</p></td>
    </tr>
    <tr>
        <td class="tr15 td37"><p class="p55 ft73">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr3 td35"><p class="p53 ft70">Fecha:</p></td>
        <td rowspan=2 class="tr8 td38"><p class="p56 ft70">03 de Junio del 2020</p></td>
    </tr>
    <tr>
        <td class="tr18 td35"><p class="p55 ft75">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr19 td37"><p class="p55 ft76">&nbsp;</p></td>
        <td class="tr19 td36"><p class="p55 ft76">&nbsp;</p></td>
    </tr>
    </table>
    <table cellpadding=0 cellspacing=0 class="t11">
    <tr>
        <td class="tr20 td39"><p class="p129 ft77">__________________________</p></td>
        <td class="tr21 td40"><p class="p130 ft64">Huella</p></td>
    </tr>
    <tr>
        <td class="tr22 td41"><p class="p131 ft78">FIRMA DEL(A) TRABAJADOR (A)</p></td>
        <td class="tr22 td42"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    </table>
    </div>
    <div id="id17_2">
    <p class="p132 ft62">REGLAMENTO INTERNO DE SEGURIDAD Y SALUD EN EL TRABAJO</p>
    <p class="p133 ft41">COMPROMISO</p>
    <p class="p134 ft40">Considerando que todos los que trabajamos en Sociedad Agrícola Rapel S.A.C., compartimos como valor fundamental el respeto por la vida y la seguridad de las personas, lo que debiera manifestarse en una permanente actitud de auto cuidado, y teniendo plena conciencia del dolor que provocan en nosotros los accidentes, en especial si sus consecuencias son fatales, me comprometo a:</p>
    <p class="p135 ft40"><span class="ft40">1.</span><span class="ft79">Que ninguna meta productiva o contingencia operacional exponga a mis compañeros o a mi persona a riesgos no suficientemente controlados.</span></p>
    <p class="p51 ft40"><span class="ft40">2.</span><span class="ft79">Cumplir la normativa, los reglamentos y los procedimientos de trabajo que se han hecho para proteger nuestras vidas.</span></p>
    <p class="p136 ft40"><span class="ft40">3.</span><span class="ft79">Analizar al inicio de cada trabajo los riesgos que tiene asociados y las medidas de control, para asegurar la ejecución del trabajo, evitar accidentes y para proteger el medio ambiente.</span></p>
    <p class="p137 ft40"><span class="ft40">4.</span><span class="ft79">Informar las condiciones inseguras que pudieran existir en los lugares donde desarrollo mis actividades y hacer lo que esté a mi alcance para eliminarlas y/o controlarlas.</span></p>
    <p class="p138 ft40"><span class="ft40">5.</span><span class="ft79">Participar activamente en los planes y programas que se implementen para fomentar en nosotros una conducta segura y responsable.</span></p>
    <p class="p139 ft40">Los principios antes mencionados se traducen en acciones concretas que tendré presente y guiarán mi trabajo en todo momento, según corresponda, comprometiendo <span class="ft80">SIEMPRE </span>a:</p>
    <p class="p140 ft40"><span class="ft81">-</span><span class="ft82">Usar correctamente los elementos de protección personal.</span></p>
    <p class="p141 ft40"><span class="ft81">-</span><span class="ft82">Operar sólo los equipos para los cuales estoy autorizado.</span></p>
    <p class="p142 ft40"><span class="ft81">-</span><span class="ft82">Intervenir o permitir intervenir solo equipos que estén des energizados y bloqueados.</span></p>
    <p class="p142 ft40"><span class="ft81">-</span><span class="ft82">Trabajar con equipos, materiales y herramientas en buen estado.</span></p>
    <p class="p142 ft40"><span class="ft81">-</span><span class="ft82">Cuidar obedecer las señalizaciones y los dispositivos de seguridad diseñados para protegerme.</span></p>
    <p class="p142 ft40"><span class="ft81">-</span><span class="ft82">Ubicarme fuera del alcance de equipos en movimiento y fuentes de energía.</span></p>
    <p class="p142 ft40"><span class="ft81">-</span><span class="ft82">Conducir atento a las condiciones del tránsito y a una velocidad razonable y prudente.</span></p>
    <p class="p143 ft40">El compromiso que aquí suscribo voluntariamente, expresa mi firme decisión de proteger mi integridad física y mi vida, así como la de mis compañeros de trabajo. Constituyendo además un incentivo para que todos los que trabajamos en esta Empresa; ejecutivos, profesionales, supervisores y trabajadores, continuemos cumpliendo nuestras obligaciones en materia de prevención de riesgos por nuestro propio bienestar y el de nuestras familias.</p>
    <table cellpadding=0 cellspacing=0 class="t12">
    <tr>
        <td class="tr8 td33"><p class="p54 ft42">Nombres:</p></td>
        <td class="tr8 td43"><p class="p56 ft42">LUIS</p></td>
    </tr>
    <tr>
        <td class="tr3 td35"><p class="p54 ft42">Apellidos:</p></td>
        <td rowspan=2 class="tr16 td44"><p class="p56 ft42">RUFINO ALAMA</p></td>
    </tr>
    <tr>
        <td class="tr23 td37"><p class="p55 ft83">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr3 td35"><p class="p54 ft42">Cargo:</p></td>
        <td rowspan=2 class="tr16 td44"><p class="p56 ft42">OBRERO DE CAMPO</p></td>
    </tr>
    <tr>
        <td class="tr23 td37"><p class="p55 ft83">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr3 td35"><p class="p54 ft42">DNI N° :</p></td>
        <td rowspan=2 class="tr16 td44"><p class="p56 ft42">73273262</p></td>
    </tr>
    <tr>
        <td class="tr23 td37"><p class="p55 ft83">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr3 td35"><p class="p54 ft42">Fecha:</p></td>
        <td rowspan=2 class="tr16 td44"><p class="p56 ft42">03 de Junio del 2020</p></td>
    </tr>
    <tr>
        <td class="tr23 td37"><p class="p55 ft83">&nbsp;</p></td>
    </tr>
    </table>
    <table cellpadding=0 cellspacing=0 class="t13">
    <tr>
        <td class="tr24 td45"><p class="p48 ft84">__________________________</p></td>
        <td class="tr25 td46"><p class="p144 ft64">Huella</p></td>
    </tr>
    <tr>
        <td rowspan=2 class="tr22 td45"><p class="p145 ft46">FIRMA DEL(A) TRABAJADOR</p></td>
        <td class="tr15 td47"><p class="p55 ft73">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr7 td48"><p class="p55 ft54">&nbsp;</p></td>
    </tr>
    </table>
    </div>
    </div>
    </div>
    <div id="page_18">


    </div>
    <div id="page_19">
    <div id="p19dimg1">
    <img src="data:image/jpg;base64,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" id="p19img1"></div>


    <div class="dclr"></div>
    <p class="p146 ft85">Cap – 01 REM</p>
    <p class="p147 ft64">CARTA COMPROMISO <span class="ft85">Versión: 0.1</span></p>
    <p class="p148 ft85">Fundo: El Papayo</p>
    <p class="p149 ft86">CARTA DE COMPROMISO PERSONAL EN EL CAMPO Y PACKING</p>
    <p class="p150 ft88"><span class="ft87">Relator (es): </span>SALAZAR CAMPOS KARLA MAGALY.</p>
    <p class="p151 ft89">COMO PERSONAL DEL FUNDO NOS ENCONTRAMOS ENTRENADOS E INFORMADOS CON LAS BUENAS PRACTICAS AGRICOLAS (BPA) Y BUENAS PRACTICAS DE MANOFACTURA (BPM) QUE CONSTA EN NORMAS DE HIGIENE Y HABITOS PARA LA SEGURIDAD DEL PERSONAL Y LOS ALIMENTOS. NOS COMPROMETEMOS A CUMPLIR LAS NORMAS ESTABLECIDAS Y MENCIONADAS EN ESTAS CHARLAS.</p>
    <p class="p65 ft89">NOS ENCONTRAMOS INSTRUIDOS PARA PREVENIR RIESGOS EN EL TRABAJO Y PARA DAR AVISO EN CASO DE ACCIDENTE O ENFERMEDAD, CUALQUIERA EVENTUALIDAD DEBERÉ DAR AVISO A MI SUPERVISOR O JEFE DIRECTO PARA QUE TOME ACCIONES AL RESPECTO<span class="ft87">.</span></p>
    <p class="p15 ft87">Me comprometo a:</p>
    <p class="p152 ft87"><span class="ft87">∙</span><span class="ft90">Notificar enfermedad antes de comenzar la faena o ante los primeros síntomas.</span></p>
    <p class="p153 ft93"><span class="ft91">∙</span><span class="ft92">Verificar antes de ingresar a un cuartel que no tenga bandera Roja (peligro no entrar por 48 horas), bandera Amarrilla (peligro no comer) y bandera verde (autorizado a cosechar – fruta libre de químicos).</span></p>
    <p class="p154 ft94"><span class="ft94">∙</span><span class="ft95">Toda hemorragia debe ser informada a los respectivos supervisores y toda fruta expuesta a sangre debe ser desechada.</span></p>
    <p class="p152 ft87"><span class="ft87">∙</span><span class="ft96">Iniciar turnos de trabajo con MANOS LIMPIAS, UÑAS CORTAS Y SIN BARNIZ.</span></p>
    <p class="p154 ft91"><span class="ft91">∙</span><span class="ft97">El lavado de manos debe realizarse al ingresar a los fundos o inicio de labor, antes y después de ir al baño, antes y después de su refrigerio y en cada cambio de actividad.</span></p>
    <p class="p152 ft91"><span class="ft91">∙</span><span class="ft98">Antes de ingresar a los fundos o área de trabajo se debe pasar por los pediluvios (Cal o Hipoclorito).</span></p>
    <p class="p154 ft91"><span class="ft91">∙</span><span class="ft97">Hacer buen uso de instalaciones sanitarias: Lavarse las manos según el instructivo que aparece impreso en las estaciones de lavado de manos.</span></p>
    <p class="p153 ft94"><span class="ft94">∙</span><span class="ft95">Lavado de manos: humedecer las manos y enjabonar, frotar durante 20 segundos, limpiando entre los dedos, bajo las uñas hasta las muñecas. Enjuagara bajo el chorro de agua hasta retirar todo el jabón, secar con papel, botarlo en basurero.</span></p>
    <p class="p154 ft91"><span class="ft91">∙</span><span class="ft97">DAMAS: cabello tomado, totalmente dentro de la cofia, sin maquillaje, sin joyas (collares, aros, anillos, uñas cortas).</span></p>
    <p class="p152 ft87"><span class="ft87">∙</span><span class="ft96">VARONES: cabello corto, barba rasurada.</span></p>
    <p class="p154 ft91"><span class="ft91">∙</span><span class="ft97">En las instalaciones está PROHIBIDO : Ingresar fruta a los Fundos o Packing, fumar, bebidas alcohólicas, Comer, mascar chicle , escupir , estornudar o toser sobre la fruta.</span></p>
    <p class="p152 ft91"><span class="ft91">∙</span><span class="ft97">Ropa limpia, prohibido el uso de Pantalones cortos y sudaderas y uso de calzado cerrado.</span></p>
    <p class="p152 ft91"><span class="ft91">∙</span><span class="ft98">Es obligación el uso de delantal y/o cotonas en las instalaciones.</span></p>
    <p class="p152 ft99"><span class="ft99">∙</span><span class="ft100">El personal debe avisar a su supervisor cuando tenga que ir al baño.</span></p>
    <p class="p152 ft91"><span class="ft91">∙</span><span class="ft98">El personal solo puede transitar por las áreas permitidas.</span></p>
    <p class="p152 ft99"><span class="ft99">∙</span><span class="ft100">Uso correcto de basureros según su clasificación (cartón/papel, madera, plásticos, etc.).</span></p>
    <p class="p152 ft91"><span class="ft91">∙</span><span class="ft98">Cuidado del medio Ambiente.</span></p>
    <p class="p154 ft91"><span class="ft91">∙</span><span class="ft97">Toda persona que encuentre material, de valor arqueológico, deberá identificar el lugar y dar aviso de inmediato a aseguramiento de calidad del campo. a su vez este dará aviso al administrador y a autoridades.</span></p>
    <p class="p6 ft101">TEMAS:</p>
    <p class="p152 ft103"><span class="ft89">∙</span><span class="ft102">HIGIENE Y HABITOS DEL PERSONAL</span></p>
    <p class="p142 ft103"><span class="ft89">∙</span><span class="ft102">DEBERES, CUIDADOS Y MANEJOS CON LOS ALIMENTOS</span></p>
    <p class="p141 ft103"><span class="ft89">∙</span><span class="ft102">POLITICAS DE LA EMPRESA</span></p>
    <p class="p142 ft103"><span class="ft89">∙</span><span class="ft102">EVALUACION DE RIESGOS</span></p>
    <p class="p142 ft103"><span class="ft89">∙</span><span class="ft102">INSTRUCCIONES PARA LIMPIEZA Y DESINFECCIÓN DE NUESTRA AREA</span></p>
    <p class="p19 ft88">NUESTRO DEBER ES HACER CUMPLIR LAS NORMAS DE LA EMPRESA</p>
    <p class="p155 ft88">Estamos en pleno conocimiento de los riesgos típicos de las labores que desempeñaremos en las instalaciones, informado por nuestro Jefe directo y Aseguramiento de calidad.</p>
    <table cellpadding=0 cellspacing=0 class="t14">
    <tr>
        <td class="tr5 td49"><p class="p55 ft88">NOMBRE</p></td>
        <td class="tr5 td19"><p class="p156 ft88">:</p></td>
        <td class="tr5 td50"><p class="p55 ft104">&nbsp;</p></td>
        <td colspan=2 class="tr5 td51"><p class="p157 ft88">RUFINO ALAMA, LUIS</p></td>
    </tr>
    <tr>
        <td rowspan=2 class="tr26 td49"><p class="p55 ft88">FIRMA</p></td>
        <td rowspan=2 class="tr26 td19"><p class="p156 ft88">:</p></td>
        <td class="tr27 td52"><p class="p55 ft105">&nbsp;</p></td>
        <td class="tr27 td53"><p class="p55 ft105">&nbsp;</p></td>
        <td class="tr27 td54"><p class="p55 ft105">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr28 td50"><p class="p55 ft104">&nbsp;</p></td>
        <td class="tr28 td55"><p class="p55 ft104">&nbsp;</p></td>
        <td class="tr28 td9"><p class="p55 ft104">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr15 td49"><p class="p55 ft106">&nbsp;</p></td>
        <td class="tr15 td19"><p class="p55 ft106">&nbsp;</p></td>
        <td class="tr15 td50"><p class="p55 ft106">&nbsp;</p></td>
        <td class="tr18 td53"><p class="p55 ft107">&nbsp;</p></td>
        <td class="tr15 td9"><p class="p55 ft106">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr29 td49"><p class="p55 ft88">FECHA</p></td>
        <td class="tr29 td19"><p class="p156 ft88">:</p></td>
        <td class="tr29 td50"><p class="p55 ft104">&nbsp;</p></td>
        <td colspan=2 class="tr29 td51"><p class="p157 ft88">03 de Junio del 2020</p></td>
    </tr>
    <tr>
        <td class="tr23 td49"><p class="p55 ft108">&nbsp;</p></td>
        <td class="tr23 td19"><p class="p55 ft108">&nbsp;</p></td>
        <td class="tr23 td50"><p class="p55 ft108">&nbsp;</p></td>
        <td class="tr15 td53"><p class="p55 ft106">&nbsp;</p></td>
        <td class="tr23 td9"><p class="p55 ft108">&nbsp;</p></td>
    </tr>
    </table>
    </div>
    <div id="page_20">


    </div>
    <div id="page_21">
    <div id="p21dimg1">
    <img src="data:image/jpg;base64,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iigAooooAK4z4iWs95Y6bAg1P7O10PP+xQPOm3B4lSNlkK+6njHriuzoqoS5ZXBnnHgjWNc0fwrBDreh61LcyNcPCFjeUrHHGGAfcxZCx3KqnqR2GKwfCMvjLQ/EiarrWkatJaarHNJcon75UY5kTbGuTGc/Jh8fePTHHstFa+2Wvu7k2PMfFEt1q2s6Xe6hpPiOXw9LYOwsbOJ1mjutxwZVQ5Hy4xk4z7bq6rw1qdwtrpml3en60s7WIna5vVDhecCOSQYzJjnGAcdec10lFRKonHlsOwUUUVmMKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAM/Qf+Re0z/r0i/9AFaFZ+g/8i9pn/XpF/6AK0KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAM/Qf+Re0z/r0i/8AQBWhWfoP/IvaZ/16Rf8AoArQoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigDw/Xv+Rh1P8A6+5f/QzRRr3/ACMOp/8AX3L/AOhmigD2DQf+Re0z/r0i/wDQBWhWfoP/ACL2mf8AXpF/6AK0KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA8P17/kYdT/6+5f/AEM0Ua9/yMOp/wDX3L/6GaKAPYNB/wCRe0z/AK9Iv/QBWhWfoP8AyL2mf9ekX/oArQoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigDw/Xv+Rh1P/r7l/wDQzRRr3/Iw6n/19y/+hmigD2DQf+Re0z/r0i/9AFaFZ+g/8i9pn/XpF/6AK0KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA8P17/AJGHU/8Ar7l/9DNFGvf8jDqf/X3L/wChmigD2DQf+Re0z/r0i/8AQBWhWfoP/IvaZ/16Rf8AoArQoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigDw/Xv+Rh1P8A6+5f/QzRRr3/ACMOp/8AX3L/AOhmigD2DQf+Re0z/r0i/wDQBWhWfoP/ACL2mf8AXpF/6AK0KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA8P17/kYdT/6+5f/AEM0Ua9/yMOp/wDX3L/6GaKAPYNB/wCRe0z/AK9Iv/QBWhWfoP8AyL2mf9ekX/oArQoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigDw/Xv+Rh1P/r7l/wDQzRRr3/Iw6n/19y/+hmigD2DQf+Re0z/r0i/9AFaFZ+g/8i9pn/XpF/6AK0KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA8P17/AJGHU/8Ar7l/9DNFGvf8jDqf/X3L/wChmigD2DQf+Re0z/r0i/8AQBWhWfoP/IvaZ/16Rf8AoArQoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigDw/Xv+Rh1P8A6+5f/QzRRr3/ACMOp/8AX3L/AOhmigD2DQf+Re0z/r0i/wDQBWhWfoP/ACL2mf8AXpF/6AK0KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA8P17/kYdT/6+5f/AEM0Ua9/yMOp/wDX3L/6GaKAPYNB/wCRe0z/AK9Iv/QBWhWfoP8AyL2mf9ekX/oArQoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigDw/Xv+Rh1P/r7l/wDQzRRr3/Iw6n/19y/+hmigD2DQf+Re0z/r0i/9AFaFZ+g/8i9pn/XpF/6AK0KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA8P17/AJGHU/8Ar7l/9DNFGvf8jDqf/X3L/wChmigD2DQf+Re0z/r0i/8AQBWhWfoP/IvaZ/16Rf8AoArQoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigDw/Xv+Rh1P8A6+5f/QzRRr3/ACMOp/8AX3L/AOhmigD2DQf+Re0z/r0i/wDQBWhWfoP/ACL2mf8AXpF/6AK0KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA8P17/kYdT/6+5f/AEM0Ua9/yMOp/wDX3L/6GaKAPYNB/wCRe0z/AK9Iv/QBWhWfoP8AyL2mf9ekX/oArQoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigDw/Xv+Rh1P/r7l/wDQzRRr3/Iw6n/19y/+hmigD2DQf+Re0z/r0i/9AFaFZ+g/8i9pn/XpF/6AK0KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA8P17/AJGHU/8Ar7l/9DNFGvf8jDqf/X3L/wChmigD2DQf+Re0z/r0i/8AQBWhWfoP/IvaZ/16Rf8AoArQoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigDw/Xv+Rh1P8A6+5f/QzRRr3/ACMOp/8AX3L/AOhmigD2DQf+Re0z/r0i/wDQBWhWfoP/ACL2mf8AXpF/6AK0KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA8P17/kYdT/6+5f/AEM0Ua9/yMOp/wDX3L/6GaKAPYNB/wCRe0z/AK9Iv/QBWhWfoP8AyL2mf9ekX/oArQoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigDw/Xv+Rh1P/r7l/wDQzRRr3/Iw6n/19y/+hmigD2DQf+Re0z/r0i/9AFaFZ+g/8i9pn/XpF/6AK0KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA8P17/AJGHU/8Ar7l/9DNFGvf8jDqf/X3L/wChmigD2DQf+Re0z/r0i/8AQBWhWfoP/IvaZ/16Rf8AoArQoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigDw/Xv+Rh1P8A6+5f/QzRRr3/ACMOp/8AX3L/AOhmigD2DQf+Re0z/r0i/wDQBWhWfoP/ACL2mf8AXpF/6AK0KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA8P17/kYdT/6+5f/AEM0Ua9/yMOp/wDX3L/6GaKAPYNB/wCRe0z/AK9Iv/QBWhWfoP8AyL2mf9ekX/oArQoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigDw/Xv+Rh1P/r7l/wDQzRRr3/Iw6n/19y/+hmigD2DQf+Re0z/r0i/9AFaFZ+g/8i9pn/XpF/6AK0KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA8P17/AJGHU/8Ar7l/9DNFGvf8jDqf/X3L/wChmigD2DQf+Re0z/r0i/8AQBWhWfoP/IvaZ/16Rf8AoArQoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigDw/Xv+Rh1P8A6+5f/QzRRr3/ACMOp/8AX3L/AOhmigD2DQf+Re0z/r0i/wDQBWhWfoP/ACL2mf8AXpF/6AK0KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA8P17/kYdT/6+5f/AEM0Ua9/yMOp/wDX3L/6GaKAPYNB/wCRe0z/AK9Iv/QBWhWfoP8AyL2mf9ekX/oArQoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigDw/Xv+Rh1P/r7l/wDQzRRr3/Iw6n/19y/+hmigD2DQf+Re0z/r0i/9AFaFZ+g/8i9pn/XpF/6AK0KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA8P17/AJGHU/8Ar7l/9DNFGvf8jDqf/X3L/wChmigD2DQf+Re0z/r0i/8AQBWhWfoP/IvaZ/16Rf8AoArQoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigDw/Xv+Rh1P8A6+5f/QzRRr3/ACMOp/8AX3L/AOhmigD2DQf+Re0z/r0i/wDQBWhWfoP/ACL2mf8AXpF/6AK0KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA8P17/kYdT/6+5f/AEM0Ua9/yMOp/wDX3L/6GaKAPYNB/wCRe0z/AK9Iv/QBWhWfoP8AyL2mf9ekX/oArQoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigDw/Xv+Rh1P/r7l/wDQzRRr3/Iw6n/19y/+hmigD2DQf+Re0z/r0i/9AFaFZ+g/8i9pn/XpF/6AK0KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA8P17/AJGHU/8Ar7l/9DNFGvf8jDqf/X3L/wChmigD2DQf+Re0z/r0i/8AQBWhWfoP/IvaZ/16Rf8AoArQoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigDw/Xv+Rh1P8A6+5f/QzRRr3/ACMOp/8AX3L/AOhmigD2DQf+Re0z/r0i/wDQBWhWfoP/ACL2mf8AXpF/6AK0KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA8P17/kYdT/6+5f/AEM0Ua9/yMOp/wDX3L/6GaKAPYNB/wCRe0z/AK9Iv/QBWhWfoP8AyL2mf9ekX/oArQoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigDw/Xv+Rh1P/r7l/wDQzRRr3/Iw6n/19y/+hmigD2DQf+Re0z/r0i/9AFaFZ+g/8i9pn/XpF/6AK0KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA8P17/AJGHU/8Ar7l/9DNFGvf8jDqf/X3L/wChmigD2DQf+Re0z/r0i/8AQBWhWfoP/IvaZ/16Rf8AoArQoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigDw/Xv+Rh1P8A6+5f/QzRRr3/ACMOp/8AX3L/AOhmigD2DQf+Re0z/r0i/wDQBWhWDoutaVFoWnxyanZo6W0asrTqCCFGQRmr39vaP/0FrH/wIT/GgDQorP8A7e0f/oLWP/gQn+NH9vaP/wBBax/8CE/xoA0KKz/7e0f/AKC1j/4EJ/jR/b2j/wDQWsf/AAIT/GgDQorP/t7R/wDoLWP/AIEJ/jR/b2j/APQWsf8AwIT/ABoA0KKz/wC3tH/6C1j/AOBCf40f29o//QWsf/AhP8aANCis/wDt7R/+gtY/+BCf40f29o//AEFrH/wIT/GgDQorP/t7R/8AoLWP/gQn+NH9vaP/ANBax/8AAhP8aANCis/+3tH/AOgtY/8AgQn+NH9vaP8A9Bax/wDAhP8AGgDQorP/ALe0f/oLWP8A4EJ/jR/b2j/9Bax/8CE/xoA0KKz/AO3tH/6C1j/4EJ/jR/b2j/8AQWsf/AhP8aANCis/+3tH/wCgtY/+BCf40f29o/8A0FrH/wACE/xoA0KKz/7e0f8A6C1j/wCBCf40f29o/wD0FrH/AMCE/wAaANCis/8At7R/+gtY/wDgQn+NH9vaP/0FrH/wIT/GgDQorP8A7e0f/oLWP/gQn+NH9vaP/wBBax/8CE/xoA0KKz/7e0f/AKC1j/4EJ/jR/b2j/wDQWsf/AAIT/GgDQorP/t7R/wDoLWP/AIEJ/jR/b2j/APQWsf8AwIT/ABoA0KKz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orP/ALB0f/oE2P8A4Dp/hR/YOj/9Amx/8B0/woA0KKz/AOwdH/6BNj/4Dp/hR/YOj/8AQJsf/AdP8KANCis/+wdH/wCgTY/+A6f4Uf2Do/8A0CbH/wAB0/woA0KKz/7B0f8A6BNj/wCA6f4Uf2Fo/wD0CrH/AMB0/wAKANCis/8AsHR/+gTY/wDgOn+FH9g6P/0CbH/wHT/CgDQorP8A7B0f/oE2P/gOn+FH9g6P/wBAmx/8B0/woA0KKz/7B0f/AKBNj/4Dp/hR/YOj/wDQJsf/AAHT/CgDQorP/sHR/wDoE2P/AIDp/hR/YOj/APQJsf8AwHT/AAoA0KKz/wCwdH/6BNj/AOA6f4Uf2Do//QJsf/AdP8KANCis/wDsHR/+gTY/+A6f4Uf2Do//AECbH/wHT/CgDQorP/sHR/8AoE2P/gOn+FH9g6P/ANAmx/8AAdP8KANCis/+wdH/AOgTY/8AgOn+FH9g6P8A9Amx/wDAdP8ACgDx/Xv+Rh1P/r7l/wDQzRXsH9g6P/0CbH/wHT/CigDQooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKiuLiK1gaaeRY416sxwB2oAlorLDXWpq21prK3P3W2gSv74YHaPqM/SpNKR41uojLJLEk5WJpHLnG1c8nk/NvFVygaFFFFSAUUUUAFFFFABRRRQAUUUUAFFFVLy88plt4QHupB8ieg7sfQD/6w5oSuBJcXUdvtU/NI/CRr95j7f49qznjvP7Usi91yzOzwLwgjCnn3O4pz/LnN60tEtVZmdpJnOZJX6uf5ADsB0qKzZbm7ubkKwCnyEJOQwXOSPT5iwP+6KpO17AX6KKKkAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiqV1eMr/Z7VRNcn+H+GP3cjoPTue3sWvsA+6vBb7Y0QyzvnZEvU+5PYe9RxWTyTR3N6/mSpyqLxGh9QO57ZP4YyRUtraLbhnY755OZJD1Y/wBAOcDtSX14LSEFVMs7nbFCpAaRvQe3cnsMntVX6ICHULx4mitbXa15OcIG5CKOrt7D9SQO+RYsbRLGzjt42ZguSWbqxJySfckk/jUOn2LW/mT3DiS8mwZXHQY6KvooycfiepNXqTfRAFFFFIAooooAKKKKACiiigAooqtd3fkBUjTzbh/9XED19yeyjIye3ucAgDLu7dHW3tgr3L9AeiL/AHm9vQdzxxyQ+1s0tjI+5pJZDl5H6n0H0HYf4mo9NSLynkWeK4mdz50seOWHGOOmBgY9qszzJbwtI5+VRnpn/wDXTfZAVdRuXQxWtuwFzcNtU9dij7z49h09yo71ZtreO1to4IhhI1CjPXAqpp8ErF726UrcTAYQn/VIPup9epPuT1AFaFD2sAUUUUgCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAoorNmu5ry5a0sTtVDtnuCOE/wBlfVv0HfPSmlcBbm5mnuDZWLKJAP30pwfJB6cd2PYfiewNq1tYrSERxg9cszHLMT1JPc0WtrFZwCKMHAySWOSxPUk9yagv9RW0KQxIZruX/VQL1PuT/Co7k/qSAXvogH31/HZRqSGklc7YoU+9I3oP8eg6niobCxkWU3t6VkvZFwdpJWNf7i57ep7nn0AfZWBhkN1cP5t5IoDv/Co/uoOy5/E9yavUXsrIAoooqQCiikyKAFoopMigBaKKKACiiq97eRWNq88pJC8BVGWYnoAO5PYUANv71LC0ed1d8YCxoMs7HgKB6k1nWWlzXKPNq4V5JiCYVOVA7Kx43AZPHTk9TzU9laT3U0eoaiqrMufJgU5WAHI/FyDgn8B3LWr+7WxspJmAYgYVScbmPAGe3Pft1NXdr3VuBFZpsu71hGscYdUQKMBgEHP64/4DUMX/ABN7lLjINhC26LB4mcdH91Hb1PPZSYbW3fUbVY2f/QTlmKgg3DEkseeQhJPHf129dpVCgADgUno/MBaKKKkAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiignFABRVO51SxtJPLnuY1lxny85Yj/dHNPtL+1vQfs8yyFfvKOGX6jqKLO17AWaKKzLmaa+uGsrR/LjTAuJweV/2F/2sd+wPrTSuAXN1NeTm0sH2gcT3AGRH6qvq/wD6D37A3ra3itLdIYUCRoMKopIIYbO3WGFFjijHAHQCsd9bTVLw2GlXKA4PmXXVRjqI+zt+g756U0nLRbAXr3UGWT7JZIJ7xgPlz8sQPRpD2HoOpwcdCQ+w09bMO7yNPcy8yzuOXP8AQDsB0/M1LZ2UFjB5UKnk7mZjlnY9WY9zVik30QBRTJJo4U3yyKiD+JiAKVHWRQyMGUjIIOQaQDqKKwdXv5573+ydPUvNsDzuDgRKc4ye2cducdOuRUYuTsBJqGsOJRaaeizXD/KGOSqngZOOSASMnoO/OAbml6bHptuy72lnkbfNM/LSN6n29B2qikmn+H4GEkwkumTcwGN7gZ6L/Cg59AOpPU1e097yVXnuyqeZgxwr/wAs19z3JqpfDpt+YF6q4tEF99r3SeZ5fl7d52YznO3pn3qvJrWnRSvG10m5PvYyefTjqRjJHUDk1fVldQykFSMgg9aizQC0VFNcQ20ZknlSNB1Z2AH5mq66raNyXdF7PJEyKfozAA0kmBakkSKNpJHCIoJZmOAAPWsy1t3v7wajdj5IywtYuyqeN5/2j+gOOuapSala6vemPz0exgYfKh3GeUc4AHJVeDx1z6CtAC6MTXF7di3iALFEAXavq7HPOOuMAevetOVxXmBPfajb6fCzyMWcY2xRjc7kkAAL3ySB+NYmlWVxrU7alqoUxB821uhymMcMf73BIHbqecghkVumr6gIkidLOPlwSQzgjGXJ5JYcAHnYxJxuXHUgADAAFF+RWW4ABiloorMAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigDMu9ZgidoLUfa7sZAghYE5HXJ6D8aWK3vrol72fyUII+z25xwfV8bs/7u38at21nbWgcW8KRh2LNtGNxPc1PVXS+ECC2s7eziMcESopOT3LH1J6k+5p0tvHIwfaBIBhXA+YfQ1LVC/uXJ+x2pP2mQcsMfukJwXOeOOw7n2zhK7YGdPcatPdPY2UsUqRkedcn5GQf3QQCC5HsMenSnuZtLslDzWthbKcBUDTO5P90nGWJz/CxJ9adDeQx25tNFhF08RKF92I1buWf+I56gZOTz61atNM8uYXd5ILq8xgSFcCMHqEX+EfmT3JrRytpb/MDM/sibXAjamLhLQDAt5ZPnl95AuFX2C89MkcitxrK2aCOEwRiOPHlqBgJjpjHT8KsUVDlJgU3t7xWzBeAKf4Zot4X6EFT+eaRLa9aQNNf8D+GGIKD9d24/lirtFK7AqR6baRy+b5IeXORJKS7D6FskD2qOeJbKNporlLaMEs/mcx89TyRj8COvSrkokMTCJlV8cFhkVSi01mnE97cNcyg5RcbY4/ovr7nJ9MU0+7AoI2tanKDFcLaWP/PUW+JX/wB0OTge7DPt0JenhPSBOZ3gklnJ3NJJM5LH1IzjPvityinzy6aAZiaHaW9rJb2qCGOQESKFDK+eobcDkVVHh5nVY5byQQpjEcbPg47EM7KR7YrdooVSS6hYq2mn2tipFvCqA/jx6DPQe3SiOwhgLGDdCCeVRvl/Beg/AVaoqbsCnHplqlz9pKGSbs8rFyv+7knb+FNvMXMyWKsQHUvLt4OzpjPYk/oDV49KywtzbardTG1edJhGEkjZQVAB+U7iOAST/wACNNNvUCJNMuNOuXk04W3kSHLQSLt2nHVWAP5EfSoJYJ9Qma3a4FxIrgu4TENuR2C8739mJAODxwDoGO9veHY2kJPKqwMrD6jhfwyfQirkEMdvCsUSBUXoBT53u9wG21tHaw+XGCBksSTkknkknuamooqACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAoooJx1oAq314LKAPsMkjsEijB5dj0A/mfQAntWda6PcOGe+uQ3nYaeONMeYx6hmyTtHQKMcDnOTVmzUXtw+oM29AWS3GMBV6FvcsQef7uMdTnSqr8uiAYkaxxiNFVUUYVVGAB9KxpfDfmvqLjWNWQ3u3hbniDH/PIY+XPStyipA87aSGHxFY6DDceMLmbTZo/OuIpg0T7z5g89sglcHHQcDHar0ei6XFot6v8Awm2rNAkyme7fVVLQlcrsL4woJPI45Aqyngq1l8ZX/iG+jV5WeJ7MpK6tGVjCksBgEk44O4cCuZtvhxq0GlmMjRDcJd20vlbX8u4SJXBEpx1beT9365zkAHQab/Zeqxw3kPiLVImvbWSxt4ZL1QW2HYZUXnMnAO7k/NkgZqs2k2c4stJtvFXiOdmmlb7Vb3nmbGCqdkrgYA9AepJ/DL074calbS6LLcTWDSWToZWQsMKs7y/J8oyTv9Vxj+LpRF8MJ4NM0i3Se0Wa0t76O4mVSGlaZCic4yQAcHPbpQB0c/hlJotRuY/FOrxx3/3HW9+SAlw37vsBkBeP4SRnmqWu2F14f0a2ltPEGsyX8SGC2iIM4uHw7HcgUljt3ck8bV9KzLnwDqsumRRraaCr/wCkxtbKJPKiEiqFkRyCfMBQHOAPQZGT09zoWpw6VoS2Fzby3+lBRuuQwjm/dGNicZYHnI6++aAOT0/QNU1jwxbSaf47vvs11IHR7jzFmMg3KyB/MB28H5eeVyDXWT+HJZbzUph4i1GM31uIEiWbCwMAo3ovZvlzxj7x781zHifwP4o8RWcKTajpstx9lMbOyBNkvmltysIy2NuF4Kk4yTyQdGDwE413R9QmiscW9xe3F5hctM0jZh6jnb15IwRxmgBkfkxxaDE/iPWIp7V43MVyjiS486Uqiyg88FSuSTgYPcZ1h4V1BdN1O1TxRqRlvGDJM7ZNuR2QdQDxkAjpxjnPPab4B1eysbC3a7thJbJaq0sZJyI55JCF3L2DrjI5244FXvBvhLUtC1drm5FtDAll9lKW8jH7S/mFhMwIGDgkd/bA6gD7e+s7jxBbafb+KL/7dDbyWWxoiY5pUX53JK7WdTg4z+hNaC+HteTS47ZfFtx9oEzSNcNaRsWQ4wgBzjGDzk9T7AZQ8PeJfs17ocbWI0p0u/KuHJMr+crbQf7rKzHJ6EHisb/hBdb1K0sLfUba1jghk0+KSFZy2+CASpJu4ABIfIA/veozQB3I0fVxcag3/CRziOf/AI91+zR5tvmzwcfNxxyOnvzVm303UI3smm1iScQhvtCmCNRcEg4PA+XGRwOuK4D/AIRHUdLTWNU1CaOEyWs2JIJWJNx5yyQMqhdxCkADczNnI+7gV3nhq0kttHSW4V0u7x2u7hHJJSSQ7inPQLwoHoooAuafZ3FnG63Ooz3zM5IeZI1Kj+6NiqPz9auUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAVQ1R2e2FrE5Wa5PlKQeVB+8w9wMke+Kv1nqvm62zMMiCABDnu7Hd+iL+dNb3AvRxpFGscahUQBVUDAAFOoopAFFFISB1IFAC0UmR6ilyPWgAoozScHigDjtX8ZXtlrj6baWEUhSWRN7+a24LFA/AjRiCTPjpj5feqP/CfaiLq/RdNtnW1nW3Kg3GQxdEzkREMMuOOGIBwDkVup4R8PpOsUCzQzwguBb30sbqjhVA+VwdmIlAHQbMDoavN4e0xtOlsRHKIZZVnZhO+8yKVIbfndnKqc57UAZF94uuLHwvBq0lnEJJZvJ2EzKqckZO6IP26BM+maxz8TnVLMjSkka5UNHHHLKXlJlkjAjHlYJIj3AOUzurs00OyW2t4HE8yW8onjM9xJKwcHIJZiScZ6Hj2qH/hGdJ/f7bXb523dtcggiR5QwOflIeR2yPX2FAFXU/F1no+stp15HKpMMEkTpG77zI7oQcKQuNo5J53Y7VX8PeNrbxFNZQwWs0ck9o9xKHRwIirIu0MVAfO5uQeNvvWzBpFlDdS3C+a8sqqjNJMznCu7qOSejSN+g6AYLTRrGxNiYEZfsVs1rCNx4jOzIPqf3a80AaFFGR60UAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABVCF1i1W5idgGkCOgJ5IxggeuMfrV+opbWCdlaWGN2XO0soJGfSmmBLRR0opAFcB8SINTMljcaYdUaWNXxFapI0TNxtLGNgVYZbHBz09a7+jGaAPLY015dT8m5h1dNZl1OOSGRZpHtobQ7cq+GCOAAQw4JOOa3PDEr6etsbqLXjcyRQW9wJ1lkhM7AlnAbJGCMFgdv3a7XaKNooA861O78WTeLNTmsrK9GmtbS2FsQxULMqFlkCHjlxtD8DBHPFZRbXLlfs2mQa3GJPsmZry6uSI5N4Dq+QGB+ZtxRtu1QRg161jijaPzoA8mNrr9tLZy3MmqLCggGovCZA20T3GVDbmdlUlRkEkptPei/k1LKm3bxWLWXT5lsQZZPNNz57Ebyp/u4xv/AIMd69Z2ijaKAPOYfEV/baJrtjsv59ce9uBbQiOUhFaTamyQrt2rnI7YFTqmuHwTDZk6impQaikMjTytvZGlBXdJGcldjqCynjB9K7/FG0UAePy6l4sW3sbW3i1G4n0+eW/1CAuQBGspCwecxJcEK/B3kgrjIHD9W03xb9i1bV7bWb2G3juLhRGtzMzuPPAULHj5AAD8wJ4A4AzXruBRigDy3wzrs9r4oszfXl0dPubJ44/3l1PG9wZFx/rUBB2j0wMnB+Y1satPfw/EewEVxqEtu4jBtYjKiAANuf7piZfmBbJDAqMdge62jFGKAOVXVNYk8XBhZ3g0ZS1tv8kBGJUN5mCd+d4Kfd24OQeam82S28Q3d3fT6giRljbxxKzQtbrChYlVBBIkLYPD5wBwQD0m0YxRtBGCKABTlQf6YpaBxRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRVGTRdKlkaSTTLN3clmZoFJJPUk4pv9g6P/0CbH/wHT/CgDQorP8A7B0f/oE2P/gOn+FH9g6P/wBAmx/8B0/woA0KKz/7B0f/AKBNj/4Dp/hV6ONIo1jjRURAFVVGAAOgAoAdRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUVRksLl5GZdWvEBJIRUhwvsMxk/mab/AGddf9Bm+/74g/8AjdAGhRWf/Z11/wBBm+/74g/+N0f2ddf9Bm+/74g/+N0AaFFZ/wDZ11/0Gb7/AL4g/wDjdXo1KRqrOzkAAu2Mt7nAA/IUAOooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKoyRaqZGMd7ZqhJ2hrRiQO2T5gz+Qpvk6x/z/WP/AIBP/wDHaANCis/ydY/5/rH/AMAn/wDjtHk6x/z/AFj/AOAT/wDx2gDQorP8nWP+f6x/8An/APjtXow4jUSMrOANxVcAnvgZOPzNADqKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiqMl/cpIyrpN44BIDq8OG9xmQH8xTf7Ruv8AoDX3/fcH/wAcoA0KKz/7Ruv+gNff99wf/HKP7Ruv+gNff99wf/HKANCis/8AtG6/6A19/wB9wf8Axyr0bF41ZkZCQCUbGV9jgkfkaAHUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFc//wAJv4d/6CH/AJBk/wDiaP8AhN/Dv/QQ/wDIMn/xNAHQUVz/APwm/h3/AKCH/kGT/wCJo/4Tfw7/ANBD/wAgyf8AxNAHQUVz/wDwm/h3/oIf+QZP/ia3IJ47m3iuIW3RSoHRsYyCMg80ASUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQB//2Q==" id="p21img1"></div>


    <div class="dclr"></div>
    <p class="p158 ft109">FICHA DE INGRESO Y CONTRATACIÓN</p>
    <table cellpadding=0 cellspacing=0 class="t15">
    <tr>
        <td class="tr3 td56"><p class="p159 ft49">Código:</p></td>
        <td class="tr3 td57"><p class="p108 ft49">044963</p></td>
        <td class="tr5 td58"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr5 td59"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr5 td60"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr5 td49"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr5 td61"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr5 td62"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr5 td63"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr5 td64"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr5 td65"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr5 td66"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr7 td67"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td68"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td69"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td70"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td71"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td72"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td73"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td74"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td75"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td76"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td77"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td78"><p class="p55 ft54">&nbsp;</p></td>
    </tr>
    <tr>
        <td rowspan=2 class="tr8 td79"><p class="p159 ft49">Apellido Paterno:</p></td>
        <td class="tr10 td80"><p class="p55 ft59">&nbsp;</p></td>
        <td rowspan=2 class="tr8 td58"><p class="p160 ft49">RUFINO</p></td>
        <td class="tr10 td81"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr10 td82"><p class="p157 ft49">Apellido</p></td>
        <td class="tr10 td49"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr10 td61"><p class="p55 ft59">&nbsp;</p></td>
        <td colspan=2 rowspan=2 class="tr8 td83"><p class="p161 ft49">ALAMA</p></td>
        <td class="tr10 td64"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr10 td65"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr10 td66"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr17 td80"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td81"><p class="p55 ft74">&nbsp;</p></td>
        <td rowspan=2 class="tr10 td84"><p class="p157 ft49">Materno:</p></td>
        <td class="tr17 td49"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td61"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td64"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td65"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td66"><p class="p55 ft74">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr17 td67"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td85"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td69"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td86"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td72"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td73"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td74"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td75"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td76"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td77"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td78"><p class="p55 ft74">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr3 td79"><p class="p159 ft49">Nombres:</p></td>
        <td class="tr3 td80"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td58"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td59"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td60"><p class="p162 ft49">LUIS</p></td>
        <td class="tr3 td49"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td61"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td62"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td63"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td64"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td65"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td66"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr18 td67"><p class="p55 ft75">&nbsp;</p></td>
        <td colspan=2 class="tr18 td87"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td70"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td71"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td72"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td73"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td74"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td75"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td76"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td77"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td78"><p class="p55 ft75">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr5 td79"><p class="p159 ft49">DNI:</p></td>
        <td colspan=2 class="tr5 td88"><p class="p163 ft49">73273262</p></td>
        <td class="tr5 td81"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr5 td82"><p class="p157 ft49">Nacionalidad:</p></td>
        <td class="tr5 td49"><p class="p55 ft59">&nbsp;</p></td>
        <td colspan=5 class="tr5 td89"><p class="p164 ft110">Peruano (a)</p></td>
        <td class="tr5 td66"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr7 td67"><p class="p55 ft54">&nbsp;</p></td>
        <td colspan=2 class="tr7 td87"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td86"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td84"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td72"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td73"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td74"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td75"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td76"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td77"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td78"><p class="p55 ft54">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr3 td79"><p class="p159 ft49">Fecha de Nacimiento:</p></td>
        <td colspan=2 class="tr3 td88"><p class="p165 ft49">06/10/1997</p></td>
        <td class="tr3 td81"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td82"><p class="p157 ft49">Estado Civil</p></td>
        <td class="tr3 td49"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td61"><p class="p55 ft59">&nbsp;</p></td>
        <td colspan=2 class="tr3 td83"><p class="p166 ft48">SOLTERO</p></td>
        <td class="tr3 td64"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td65"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td66"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr7 td67"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td85"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td69"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td86"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td84"><p class="p55 ft54">&nbsp;</p></td>
        <td colspan=2 class="tr7 td90"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td74"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td75"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td76"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td77"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td78"><p class="p55 ft54">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr3 td79"><p class="p159 ft49">Dirección (1):</p></td>
        <td class="tr3 td80"><p class="p55 ft59">&nbsp;</p></td>
        <td colspan=7 class="tr3 td91"><p class="p167 ft49">MZ. X LT. 185 CASERIO SANTA ANA - TAMBO GRANDE</p></td>
        <td class="tr3 td64"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td65"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td66"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr18 td67"><p class="p55 ft75">&nbsp;</p></td>
        <td colspan=2 class="tr18 td87"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td70"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td71"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td72"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td73"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td74"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td75"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td76"><p class="p55 ft75">&nbsp;</p></td>
        <td colspan=2 class="tr18 td92"><p class="p55 ft75">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr3 td79"><p class="p159 ft49">Departamento</p></td>
        <td colspan=2 class="tr3 td93"><p class="p168 ft49">PIURA</p></td>
        <td class="tr3 td94"><p class="p157 ft49">Provincia:</p></td>
        <td class="tr3 td82"><p class="p54 ft49">PIURA</p></td>
        <td class="tr3 td49"><p class="p169 ft49">Distrito:</p></td>
        <td class="tr3 td95"><p class="p55 ft59">&nbsp;</p></td>
        <td colspan=5 class="tr3 td96"><p class="p170 ft49">TAMBO GRANDE</p></td>
    </tr>
    <tr>
        <td class="tr18 td67"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td85"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td97"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td98"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td84"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td72"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td99"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td74"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td75"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td76"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td77"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td78"><p class="p55 ft75">&nbsp;</p></td>
    </tr>
    <tr>
        <td rowspan=2 class="tr14 td79"><p class="p159 ft49">Teléf./Celular:</p></td>
        <td class="tr0 td80"><p class="p55 ft111">&nbsp;</p></td>
        <td class="tr0 td58"><p class="p55 ft111">&nbsp;</p></td>
        <td class="tr0 td94"><p class="p55 ft111">&nbsp;</p></td>
        <td class="tr0 td82"><p class="p171 ft112">Correo</p></td>
        <td class="tr0 td49"><p class="p55 ft111">&nbsp;</p></td>
        <td class="tr0 td61"><p class="p55 ft111">&nbsp;</p></td>
        <td class="tr0 td62"><p class="p55 ft111">&nbsp;</p></td>
        <td class="tr0 td63"><p class="p55 ft111">&nbsp;</p></td>
        <td class="tr0 td64"><p class="p55 ft111">&nbsp;</p></td>
        <td class="tr0 td65"><p class="p55 ft111">&nbsp;</p></td>
        <td class="tr0 td66"><p class="p55 ft111">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr17 td80"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td58"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td94"><p class="p55 ft74">&nbsp;</p></td>
        <td rowspan=2 class="tr10 td84"><p class="p172 ft49">Electrónico:</p></td>
        <td class="tr17 td49"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td61"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td62"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td63"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td64"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td65"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td66"><p class="p55 ft74">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr17 td67"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td85"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td69"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td98"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td72"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td73"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td74"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td75"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td76"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td77"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td78"><p class="p55 ft74">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr5 td79"><p class="p159 ft49">Dirección (2):</p></td>
        <td class="tr5 td80"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr5 td58"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr5 td59"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr5 td82"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr5 td49"><p class="p169 ft84">Centro de Costo</p></td>
        <td class="tr5 td95"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr5 td62"><p class="p55 ft59">&nbsp;</p></td>
        <td colspan=4 class="tr5 td100"><p class="p173 ft49">SAN VICENTE</p></td>
    </tr>
    <tr>
        <td class="tr7 td67"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td85"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td69"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td70"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td84"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td72"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td99"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td74"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td75"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td76"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td77"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td78"><p class="p55 ft54">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr3 td79"><p class="p159 ft49">Departamento</p></td>
        <td class="tr3 td80"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td101"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td81"><p class="p157 ft49">Provincia</p></td>
        <td class="tr3 td82"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td49"><p class="p169 ft49">Distrito:</p></td>
        <td class="tr3 td95"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td62"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td63"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td64"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td65"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td66"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr18 td67"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td85"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td97"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td86"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td84"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td72"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td99"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td74"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td75"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td76"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td77"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td78"><p class="p55 ft75">&nbsp;</p></td>
    </tr>
    <tr>
        <td rowspan=2 class="tr29 td79"><p class="p159 ft49">Sistema Pensionario:</p></td>
        <td class="tr3 td80"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td101"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td81"><p class="p157 ft44">Seguro</p></td>
        <td rowspan=2 class="tr29 td82"><p class="p157 ft47">ESSALUD</p></td>
        <td rowspan=2 class="tr29 td49"><p class="p169 ft49">Hijos:</p></td>
        <td class="tr3 td95"><p class="p55 ft59">&nbsp;</p></td>
        <td rowspan=2 class="tr29 td102"><p class="p161 ft49">SI</p></td>
        <td class="tr3 td103"><p class="p55 ft59">&nbsp;</p></td>
        <td rowspan=2 class="tr29 td104"><p class="p174 ft49">NO</p></td>
        <td class="tr3 td65"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td66"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr30 td80"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td101"><p class="p55 ft113">&nbsp;</p></td>
        <td rowspan=2 class="tr0 td81"><p class="p157 ft44">Social:</p></td>
        <td class="tr30 td95"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td103"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td65"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td66"><p class="p55 ft113">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr15 td79"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td80"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td101"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td82"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td49"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td95"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td102"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td103"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td104"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td65"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td66"><p class="p55 ft73">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr18 td67"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td85"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td97"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td86"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td84"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td72"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td99"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td105"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td106"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td107"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td77"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td78"><p class="p55 ft75">&nbsp;</p></td>
    </tr>
    <tr>
        <td rowspan=2 class="tr31 td79"><p class="p159 ft49">Cargo:</p></td>
        <td colspan=2 rowspan=2 class="tr31 td93"><p class="p159 ft48">OBRERO DE CAMPO</p></td>
        <td class="tr5 td81"><p class="p157 ft44">Nivel</p></td>
        <td class="tr5 td60"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr5 td49"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr5 td95"><p class="p55 ft59">&nbsp;</p></td>
        <td colspan=2 class="tr5 td108"><p class="p166 ft84">¿Inst. Educ.</p></td>
        <td rowspan=2 class="tr31 td104"><p class="p171 ft49">SI</p></td>
        <td class="tr5 td65"><p class="p55 ft59">&nbsp;</p></td>
        <td rowspan=2 class="tr31 td66"><p class="p175 ft49">NO</p></td>
    </tr>
    <tr>
        <td class="tr13 td81"><p class="p157 ft44">Educativo:</p></td>
        <td class="tr13 td60"><p class="p55 ft114">&nbsp;</p></td>
        <td class="tr13 td49"><p class="p55 ft114">&nbsp;</p></td>
        <td class="tr13 td95"><p class="p55 ft114">&nbsp;</p></td>
        <td colspan=2 class="tr13 td108"><p class="p166 ft42">del Perú?</p></td>
        <td class="tr13 td65"><p class="p55 ft114">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr15 td67"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td85"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td97"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td86"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td71"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td72"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td99"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td74"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td106"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td107"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td77"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td78"><p class="p55 ft73">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr3 td79"><p class="p159 ft49">Tipo de Institución</p></td>
        <td class="tr3 td80"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td101"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td81"><p class="p53 ft44">Nombre de</p></td>
        <td class="tr3 td60"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td49"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td95"><p class="p55 ft59">&nbsp;</p></td>
        <td colspan=2 rowspan=2 class="tr32 td108"><p class="p166 ft49">Régimen</p></td>
        <td rowspan=2 class="tr32 td104"><p class="p171 ft42">Pública</p></td>
        <td class="tr3 td65"><p class="p55 ft59">&nbsp;</p></td>
        <td rowspan=2 class="tr32 td66"><p class="p175 ft84">Privada</p></td>
    </tr>
    <tr>
        <td rowspan=2 class="tr10 td79"><p class="p159 ft49">Educativa</p></td>
        <td class="tr17 td80"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td101"><p class="p55 ft74">&nbsp;</p></td>
        <td rowspan=2 class="tr10 td81"><p class="p54 ft44">Inst. Educ.</p></td>
        <td class="tr17 td60"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td49"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td95"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td65"><p class="p55 ft74">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr17 td80"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td101"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td60"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td49"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td95"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td62"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td103"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td104"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td65"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td66"><p class="p55 ft74">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr18 td67"><p class="p55 ft75">&nbsp;</p></td>
        <td colspan=2 class="tr18 td109"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td86"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td71"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td72"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td99"><p class="p55 ft75">&nbsp;</p></td>
        <td colspan=2 class="tr18 td110"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td107"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td77"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td78"><p class="p55 ft75">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr10 td79"><p class="p159 ft49">Tiempo Estimado de</p></td>
        <td colspan=2 class="tr10 td93"><p class="p53 ft45">03 Meses (Periodo de</p></td>
        <td rowspan=2 class="tr8 td81"><p class="p157 ft49">Carrera</p></td>
        <td class="tr10 td60"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr10 td49"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr10 td95"><p class="p55 ft59">&nbsp;</p></td>
        <td colspan=2 class="tr10 td108"><p class="p171 ft49">Año de</p></td>
        <td class="tr10 td64"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr10 td65"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr10 td66"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td rowspan=2 class="tr1 td67"><p class="p159 ft49">Contrato</p></td>
        <td colspan=2 rowspan=2 class="tr1 td109"><p class="p171 ft45">Prueba)</p></td>
        <td class="tr17 td60"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td49"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td95"><p class="p55 ft74">&nbsp;</p></td>
        <td colspan=2 rowspan=2 class="tr1 td110"><p class="p166 ft49">Egreso</p></td>
        <td class="tr17 td64"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td65"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td66"><p class="p55 ft74">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr30 td86"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td71"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td72"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td99"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td76"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td77"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td78"><p class="p55 ft113">&nbsp;</p></td>
    </tr>
    <tr>
        <td rowspan=2 class="tr8 td79"><p class="p159 ft49">Fecha de Ingreso:</p></td>
        <td colspan=2 class="tr10 td93"><p class="p166 ft48">03 de Junio del</p></td>
        <td rowspan=2 class="tr8 td81"><p class="p157 ft49">TRONCAL:</p></td>
        <td rowspan=2 class="tr8 td82"><p class="p171 ft49">ALTO PIURA</p></td>
        <td rowspan=2 class="tr8 td49"><p class="p169 ft49">RUTA:</p></td>
        <td class="tr10 td95"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr10 td62"><p class="p55 ft59">&nbsp;</p></td>
        <td colspan=3 rowspan=2 class="tr8 td18"><p class="p176 ft49">SANTA ANA</p></td>
        <td class="tr10 td66"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td colspan=2 rowspan=2 class="tr10 td109"><p class="p166 ft48">2020</p></td>
        <td class="tr17 td95"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td62"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td66"><p class="p55 ft74">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr17 td67"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td86"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td84"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td72"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td99"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td74"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td75"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td76"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td77"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td78"><p class="p55 ft74">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr3 td79"><p class="p159 ft49">Tipo de Trabajador:</p></td>
        <td class="tr3 td111"><p class="p131 ft49">Diario:</p></td>
        <td class="tr3 td101"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td81"><p class="p157 ft49">Destajo:</p></td>
        <td class="tr3 td82"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td49"><p class="p169 ft49">Mensual:</p></td>
        <td class="tr3 td95"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td62"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td63"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td64"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td65"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td66"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr18 td67"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td68"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td97"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td86"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td84"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td72"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td99"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td74"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td75"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td76"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td77"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td78"><p class="p55 ft75">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr3 td79"><p class="p159 ft49">Tipo de Contratos:</p></td>
        <td class="tr3 td111"><p class="p131 ft49">Parcial:</p></td>
        <td class="tr3 td58"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td81"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td82"><p class="p157 ft49">Indefinido</p></td>
        <td class="tr3 td49"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td61"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td62"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td63"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td64"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td65"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td66"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr18 td67"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td68"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td69"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td86"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td84"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td72"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td73"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td74"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td75"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td76"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td77"><p class="p55 ft75">&nbsp;</p></td>
        <td class="tr18 td78"><p class="p55 ft75">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr3 td79"><p class="p159 ft49">Sueldo Bruto:</p></td>
        <td class="tr3 td80"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td58"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td81"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td82"><p class="p157 ft49">Sueldo Neto:</p></td>
        <td class="tr3 td49"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td61"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td62"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td63"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td64"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td65"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td66"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr7 td67"><p class="p55 ft54">&nbsp;</p></td>
        <td colspan=2 class="tr7 td87"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td86"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td84"><p class="p55 ft54">&nbsp;</p></td>
        <td colspan=7 class="tr7 td112"><p class="p55 ft54">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr5 td79"><p class="p159 ft49">Horario de Trabajo:</p></td>
        <td colspan=2 class="tr5 td93"><p class="p166 ft110">Lunes a Sábados</p></td>
        <td class="tr5 td81"><p class="p157 ft49">Hora:</p></td>
        <td colspan=8 class="tr5 td113"><p class="p177 ft48">6:15 a.m. a 10:15 a.m. - 11:00 a.m. a 15:00 p.m.</p></td>
    </tr>
    <tr>
        <td class="tr7 td67"><p class="p55 ft54">&nbsp;</p></td>
        <td colspan=2 class="tr7 td109"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td86"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td71"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td72"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td73"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td74"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td75"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td76"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td77"><p class="p55 ft54">&nbsp;</p></td>
        <td class="tr7 td78"><p class="p55 ft54">&nbsp;</p></td>
    </tr>
    <tr>
        <td colspan=2 class="tr0 td114"><p class="p178 ft112">En caso de Emergencia,</p></td>
        <td class="tr0 td58"><p class="p55 ft111">&nbsp;</p></td>
        <td class="tr0 td59"><p class="p55 ft111">&nbsp;</p></td>
        <td class="tr0 td82"><p class="p55 ft111">&nbsp;</p></td>
        <td colspan=2 rowspan=2 class="tr14 td115"><p class="p169 ft49">Teléf./Celular:</p></td>
        <td class="tr0 td62"><p class="p55 ft111">&nbsp;</p></td>
        <td class="tr0 td63"><p class="p55 ft111">&nbsp;</p></td>
        <td class="tr0 td64"><p class="p55 ft111">&nbsp;</p></td>
        <td class="tr0 td65"><p class="p55 ft111">&nbsp;</p></td>
        <td class="tr0 td66"><p class="p55 ft111">&nbsp;</p></td>
    </tr>
    <tr>
        <td colspan=2 rowspan=2 class="tr1 td116"><p class="p179 ft49">Comunicarse a:</p></td>
        <td class="tr17 td58"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td59"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td82"><p class="p55 ft74">&nbsp;</p></td>
        <td colspan=2 class="tr17 td83"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td64"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td65"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td66"><p class="p55 ft74">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr30 td69"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td70"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td84"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td72"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td99"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td74"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td75"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td76"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td77"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td78"><p class="p55 ft113">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr1 td117"><p class="p159 ft49">Capacitaciones:</p></td>
        <td class="tr1 td80"><p class="p131 ft115">Se realizó</p></td>
        <td colspan=9 class="tr1 td118"><p class="p169 ft115">charla de Inducción de BPA, Seguridad y Salud Ocupacional,</p></td>
        <td class="tr1 td66"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr4 td117"><p class="p55 ft59">&nbsp;</p></td>
        <td colspan=4 class="tr4 td119"><p class="p131 ft47">Bienestar Social y Remuneraciones</p></td>
        <td class="tr4 td49"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td61"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td62"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td63"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td64"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td65"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td66"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    </table>
    <p class="p180 ft49">Observaciones Varias:</p>
    <p class="p181 ft49">Declaro Bajo Juramento que la información brindada es verdadera y que en caso se determine la falsedad de la misma, será causal de falta grave.</p>
    <table cellpadding=0 cellspacing=0 class="t16">
    <tr>
        <td class="tr8 td120"><p class="p182 ft47">Firma del Trabajador</p></td>
        <td class="tr8 td121"><p class="p109 ft47">V°B° Gerente General y/o Recursos Humanos</p></td>
    </tr>
    <tr>
        <td class="tr17 td122"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td123"><p class="p55 ft74">&nbsp;</p></td>
    </tr>
    </table>
    <p class="p183 ft49">D.N.I.</p>
    <p class="p184 ft49">Certificado Antecedentes Policiales</p>
    <p class="p184 ft49">D.N.I. Esposa</p>
    <p class="p185 ft49">D.N.I. Hijos</p>
    <p class="p184 ft49">Partida/Acta de Matrimonio o Documentación de Convivencia</p>
    </div>
    <div id="page_22">


    </div>
    <div id="page_23">
    <div id="p23dimg1">
    <img src="data:image/jpg;base64,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aP8A9Bax/wDAhP8AGj+3tH/6C1j/AOBCf40AaFFZ/wDb2j/9Bax/8CE/xp0etaVLIscep2bu5CqqzqSSegAzQBerj/iP/wAi9b/9fa/+gPXYVx/xH/5F63/6+1/9AegDoNG/48ZP+vu5/wDRz1oVn6N/x4yf9fdz/wCjnrQoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAK4/4j/8i9b/APX2v/oD12Fcf8R/+Ret/wDr7X/0B6AOg0b/AI8ZP+vu5/8ARz1oVn6N/wAeMn/X3c/+jnrQoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAK4/wCI/wDyL1v/ANfa/wDoD12Fcf8AEf8A5F63/wCvtf8A0B6AOg0b/jxk/wCvu5/9HPWhWfo3/HjJ/wBfdz/6OetCgAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigArj/iP/AMi9b/8AX2v/AKA9dhXH/Ef/AJF63/6+1/8AQHoA6DRv+PGT/r7uf/Rz1oVn6N/x4yf9fdz/AOjnrQoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAK4/4j/8AIvW//X2v/oD12Fcf8R/+Ret/+vtf/QHoA6DRv+PGT/r7uf8A0c9aFZ+jf8eMn/X3c/8Ao560KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACuP+I//IvW/wD19r/6A9dhXH/Ef/kXrf8A6+1/9AegDoNG/wCPGT/r7uf/AEc9aFZ+jf8AHjJ/193P/o560KACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACuP8AiP8A8i9b/wDX2v8A6A9dhXH/ABH/AORet/8Ar7X/ANAegDoNG/48ZP8Ar7uf/Rz1oVn6N/x4yf8AX3c/+jnrQoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAK4/4j/wDIvW//AF9r/wCgPXYVx/xH/wCRet/+vtf/AEB6APL6KKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigD//2Q==" id="p23img1"></div>


    <div class="dclr"></div>
    <div id="id23_1">
    <p class="p186 ft116">FORMATO DE ELECCIÓN DEL SISTEMA PENSIONARIO</p>
    <p class="p187 ft55"><span class="ft48">I.</span><span class="ft117">DATOS DEL TRABAJADOR</span></p>
    <table cellpadding=0 cellspacing=0 class="t17">
    <tr>
        <td class="tr3 td124"><p class="p188 ft49">1.-</p></td>
        <td colspan=4 class="tr3 td125"><p class="p159 ft49">APELLIDO PATERNO:</p></td>
        <td class="tr3 td126"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td127"><p class="p55 ft59">&nbsp;</p></td>
        <td colspan=2 class="tr4 td128"><p class="p55 ft49">RUFINO</p></td>
        <td class="tr4 td129"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td130"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td131"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td132"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr3 td124"><p class="p188 ft49">2.-</p></td>
        <td colspan=4 class="tr3 td125"><p class="p159 ft49">APELLIDO MATERNO:</p></td>
        <td class="tr3 td126"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td127"><p class="p55 ft59">&nbsp;</p></td>
        <td colspan=2 class="tr4 td128"><p class="p55 ft49">ALAMA</p></td>
        <td class="tr4 td129"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td130"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td131"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td132"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr1 td124"><p class="p188 ft49">3.-</p></td>
        <td colspan=4 class="tr1 td125"><p class="p159 ft49">NOMBRES:</p></td>
        <td class="tr1 td126"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr1 td133"><p class="p55 ft59">&nbsp;</p></td>
        <td colspan=2 class="tr1 td134"><p class="p55 ft49">LUIS</p></td>
        <td class="tr1 td124"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr1 td135"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr1 td136"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr1 td137"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr5 td124"><p class="p188 ft49">4.-</p></td>
        <td rowspan=2 class="tr16 td138"><p class="p159 ft49">TIPO DE</p></td>
        <td class="tr5 td139"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr5 td140"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td141"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td142"><p class="p55 ft48">X</p></td>
        <td class="tr3 td143"><p class="p55 ft59">&nbsp;</p></td>
        <td colspan=2 class="tr3 td144"><p class="p169 ft49">D.N.I.</p></td>
        <td class="tr3 td145"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td146"><p class="p189 ft49">N°</p></td>
        <td colspan=2 class="tr4 td147"><p class="p190 ft49">73273262</p></td>
    </tr>
    <tr>
        <td class="tr15 td124"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td139"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td140"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td148"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td149"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td133"><p class="p55 ft73">&nbsp;</p></td>
        <td colspan=2 rowspan=2 class="tr0 td134"><p class="p130 ft112">Carnet</p></td>
        <td class="tr15 td124"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td135"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td136"><p class="p55 ft73">&nbsp;</p></td>
        <td class="tr15 td137"><p class="p55 ft73">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr30 td124"><p class="p55 ft113">&nbsp;</p></td>
        <td colspan=3 rowspan=2 class="tr1 td150"><p class="p159 ft49">DOCUMENTO:</p></td>
        <td class="tr30 td148"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td149"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td133"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td124"><p class="p55 ft113">&nbsp;</p></td>
        <td rowspan=2 class="tr1 td135"><p class="p189 ft49">N°</p></td>
        <td class="tr30 td136"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td137"><p class="p55 ft113">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr17 td124"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td148"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td149"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td133"><p class="p55 ft74">&nbsp;</p></td>
        <td colspan=3 rowspan=2 class="tr4 td151"><p class="p191 ft49">Extranjería</p></td>
        <td class="tr17 td136"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td137"><p class="p55 ft74">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr33 td124"><p class="p55 ft118">&nbsp;</p></td>
        <td class="tr33 td138"><p class="p55 ft118">&nbsp;</p></td>
        <td class="tr33 td139"><p class="p55 ft118">&nbsp;</p></td>
        <td class="tr33 td140"><p class="p55 ft118">&nbsp;</p></td>
        <td class="tr30 td152"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td153"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr33 td133"><p class="p55 ft118">&nbsp;</p></td>
        <td class="tr33 td135"><p class="p55 ft118">&nbsp;</p></td>
        <td class="tr30 td131"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td132"><p class="p55 ft113">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr1 td124"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr1 td138"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr1 td139"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr1 td140"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr10 td152"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr10 td153"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr1 td133"><p class="p55 ft59">&nbsp;</p></td>
        <td colspan=2 class="tr1 td134"><p class="p169 ft49">Pasaporte</p></td>
        <td class="tr1 td124"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr1 td135"><p class="p55 ft49">N°</p></td>
        <td class="tr10 td131"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr10 td132"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr10 td124"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr10 td138"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr10 td139"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr10 td140"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr10 td148"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr10 td149"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr10 td133"><p class="p55 ft59">&nbsp;</p></td>
        <td colspan=2 class="tr10 td134"><p class="p169 ft49">Otros</p></td>
        <td class="tr10 td124"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr10 td135"><p class="p55 ft49">N°</p></td>
        <td class="tr10 td136"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr10 td137"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr3 td124"><p class="p188 ft49">5.-</p></td>
        <td class="tr3 td138"><p class="p159 ft49">SEXO:</p></td>
        <td class="tr3 td154"><p class="p55 ft59">&nbsp;</p></td>
        <td colspan=2 class="tr1 td155"><p class="p192 ft49">M</p></td>
        <td class="tr1 td142"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td156"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr1 td157"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td158"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td124"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td135"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td159"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td160"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr4 td124"><p class="p188 ft49">6.-</p></td>
        <td colspan=6 class="tr4 td161"><p class="p159 ft49">FECHA DE NACIMIENTO:</p></td>
        <td colspan=4 class="tr1 td162"><p class="p189 ft49">06/10/1997</p></td>
        <td class="tr4 td136"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td137"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td rowspan=2 class="tr8 td124"><p class="p188 ft49">7.-</p></td>
        <td colspan=4 rowspan=2 class="tr8 td125"><p class="p159 ft49">DOMICILIO</p></td>
        <td colspan=8 class="tr10 td163"><p class="p169 ft49">MZ. X LT. 185 CASERIO SANTA ANA - TAMBO GRANDE</p></td>
    </tr>
    <tr>
        <td class="tr17 td126"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td133"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td66"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td158"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td124"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td135"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td136"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td137"><p class="p55 ft74">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr30 td124"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td138"><p class="p55 ft113">&nbsp;</p></td>
        <td colspan=3 class="tr30 td80"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td126"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr30 td133"><p class="p55 ft113">&nbsp;</p></td>
        <td colspan=4 class="tr17 td162"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr17 td131"><p class="p55 ft74">&nbsp;</p></td>
        <td class="tr30 td137"><p class="p55 ft113">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr4 td124"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td138"><p class="p55 ft59">&nbsp;</p></td>
        <td colspan=3 class="tr4 td80"><p class="p55 ft49">DISTRITO:</p></td>
        <td class="tr4 td126"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td133"><p class="p55 ft59">&nbsp;</p></td>
        <td colspan=4 class="tr1 td162"><p class="p156 ft49">TAMBO GRANDE</p></td>
        <td class="tr1 td131"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td137"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr3 td124"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td138"><p class="p55 ft59">&nbsp;</p></td>
        <td colspan=3 class="tr3 td80"><p class="p55 ft49">PROVINCIA:</p></td>
        <td class="tr3 td126"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td133"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td78"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td164"><p class="p55 ft59">&nbsp;</p></td>
        <td colspan=2 class="tr4 td70"><p class="p193 ft49">PIURA</p></td>
        <td class="tr4 td131"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td137"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr3 td124"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td138"><p class="p55 ft59">&nbsp;</p></td>
        <td colspan=5 class="tr3 td165"><p class="p55 ft49">DEPARTAMENTO:</p></td>
        <td class="tr4 td78"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td164"><p class="p55 ft59">&nbsp;</p></td>
        <td colspan=2 class="tr4 td70"><p class="p193 ft49">PIURA</p></td>
        <td class="tr4 td131"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td137"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    </table>
    <p class="p23 ft55"><span class="ft48">II.</span><span class="ft119">DATOS DE LA ENTIDAD EMPLEADORA</span></p>
    <table cellpadding=0 cellspacing=0 class="t18">
    <tr>
        <td colspan=2 class="tr3 td166"><p class="p55 ft49">1.- NOMBRE O RAZÓN SOCIAL:</p></td>
        <td class="tr3 td167"><p class="p194 ft45">SOCIEDAD AGRICOLA RAPEL SAC</p></td>
    </tr>
    <tr>
        <td class="tr8 td124"><p class="p55 ft49">2.-</p></td>
        <td class="tr8 td168"><p class="p159 ft49">N° DE RUC:</p></td>
        <td class="tr8 td167"><p class="p195 ft48">20451779711</p></td>
    </tr>
    <tr>
        <td rowspan=2 class="tr34 td124"><p class="p55 ft49">3.-</p></td>
        <td class="tr35 td168"><p class="p159 ft49">DEPARTAMENTO DEL</p></td>
        <td rowspan=2 class="tr34 td167"><p class="p196 ft41">CASERIO EL PAPAYO MZ "O"- CASTILLA-PIURA</p></td>
    </tr>
    <tr>
        <td class="tr10 td168"><p class="p159 ft49">DOMICILIO FISCAL:</p></td>
    </tr>
    </table>
    </div>
    <div id="id23_2">
    <div id="id23_2_1">
    <p class="p6 ft55"><span class="ft48">III.</span><span class="ft120">DATOS DEL VÍNCULO LABORAL</span></p>
    <p class="p197 ft49"><span class="ft121">1.- </span>FECHA DE INICIO DE LA RELACIÓN LABORAL:</p>
    <p class="p198 ft49">2.- REMUNERACIÓN</p>
    </div>
    <div id="id23_2_2">
    <p class="p6 ft49">03 de Junio del 2020</p>
    <p class="p199 ft48">S/ 39.19</p>
    </div>
    </div>
    <div id="id23_3">
    <p class="p200 ft48">IV. <span class="ft55">ELECCIÓN DEL SISTEMA PENSIONARIO</span></p>
    <p class="p201 ft49">1.- DESEO AFILIARME (Marcar el que corresponda)</p>
    <p class="p202 ft122">SISTEMA NACIONAL DEL PENSIONES SISTEMA PRIVADO DE PENSIONES (AFP)</p>
    <p class="p203 ft49"><span class="ft44">*</span><span class="ft123">Si deseas afiliarte al Sistema Privado de Pensiones, llenar los siguientes datos: Correo Electrónico:</span></p>
    <p class="p204 ft49">Teléfono Fijo:</p>
    <table cellpadding=0 cellspacing=0 class="t19">
    <tr>
        <td class="tr3 td169"><p class="p205 ft49">Teléfono Móvil:</p></td>
        <td class="tr1 td170"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr1 td171"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr1 td172"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr3 td158"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td colspan=2 class="tr10 td173"><p class="p206 ft49">Envío de estado de cuenta por correo</p></td>
        <td rowspan=2 class="tr8 td174"><p class="p55 ft49">SI:</p></td>
        <td class="tr10 td175"><p class="p55 ft59">&nbsp;</p></td>
        <td rowspan=2 class="tr8 td158"><p class="p131 ft49">NO:</p></td>
    </tr>
    <tr>
        <td colspan=2 rowspan=2 class="tr4 td173"><p class="p206 ft49">electrónico:</p></td>
        <td class="tr17 td175"><p class="p55 ft74">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr33 td174"><p class="p55 ft118">&nbsp;</p></td>
        <td class="tr30 td176"><p class="p55 ft113">&nbsp;</p></td>
        <td class="tr33 td158"><p class="p55 ft118">&nbsp;</p></td>
    </tr>
    </table>
    <p class="p198 ft49">2.- ESTOY ACTUALMENTE AFILIADO (Marcar el que corresponda)</p>
    <table cellpadding=0 cellspacing=0 class="t20">
    <tr>
        <td class="tr4 td177"><p class="p55 ft48">INTEGRA</p></td>
        <td class="tr10 td178"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td179"><p class="p207 ft48">PRIMA</p></td>
    </tr>
    <tr>
        <td class="tr1 td177"><p class="p55 ft48">PROFUTURO</p></td>
        <td class="tr10 td180"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr1 td179"><p class="p207 ft48">HABITAT</p></td>
    </tr>
    <tr>
        <td class="tr4 td177"><p class="p55 ft48">HORIZONTE</p></td>
        <td class="tr1 td180"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr4 td179"><p class="p207 ft48">O.N.p.</p></td>
    </tr>
    </table>
    <p class="p208 ft49">DECLARO HABER RECIBIDO EL BOLETIN INFORMATIVO SOBRE LAS CARACTERÍSTICAS, DIFERENCIAS Y DEMÁS PECULIARIDADES PERNSIONARIOS VIGENTES SPP - SNP.</p>
    <p class="p209 ft49">Firma del</p>
    <p class="p210 ft49">Trabajador:</p>
    <table cellpadding=0 cellspacing=0 class="t21">
    <tr>
        <td class="tr4 td181"><p class="p55 ft48">RR.HH. - 2020</p></td>
        <td rowspan=2 class="tr16 td182"><p class="p46 ft49">Piura, 03 de Junio del 2020.</p></td>
    </tr>
    <tr>
        <td class="tr17 td181"><p class="p55 ft74">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr36 td181"><p class="p55 ft59">&nbsp;</p></td>
        <td class="tr36 td182"><p class="p211 ft0">73273262</p></td>
    </tr>
    </table>
    </div>
    </div>
    <div id="page_24">


    </div>
    <div id="page_25">
    <div id="p25dimg1">
    <img src="data:image/jpg;base64,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gOfVuehrfHSp5FF6Gc61ScVGTbS28gooopmYUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAVzfgKeF/BWl2aSxvcabbx6feRqwJhuIVCSRtjuGH0IwRkEE9JWXqXhrQdZuFuNU0TTb6dUCLJdWqSsFyTgFgTjJJx7mgDUorn/8AhBPB/wD0Kmh/+C6H/wCJo/4QTwf/ANCpof8A4Lof/iaAOgorn/8AhBPB/wD0Kmh/+C6H/wCJo/4QTwf/ANCpof8A4Lof/iaAOgorn/8AhBPB/wD0Kmh/+C6H/wCJo/4QTwf/ANCpof8A4Lof/iaAOgorn/8AhBPB/wD0Kmh/+C6H/wCJo/4QTwf/ANCpof8A4Lof/iaAOgorn/8AhBPB/wD0Kmh/+C6H/wCJo/4QTwf/ANCpof8A4Lof/iaAOgorn/8AhBPB/wD0Kmh/+C6H/wCJo/4QTwf/ANCpof8A4Lof/iaAOgrn/Os77x9Gtvc+ZdaXp8sd1EgBEXnvEybjnIYiBiFAPHJK5Xcf8IJ4P/6FTQ//AAXQ/wDxNbFjYWemWcdnYWkFpax52QwRiNFySThRwMkk/jQBYooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACjFFFABRRRQAYooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAry3BE3kxJvkADEMcAA55J/A05hOWBV41X+IFST+ByP5UskAkYNuKsAQCOoz/wDqqPfLCD5uGQDJkBAx1zkH8P8A61MB3lSb9xnkx/dwuP5UjWiSNud5Sf8AZlZR+hFPiuI5QNrdecYIOPXB7VLSAYsSoMDdj3Yn+dO2jOe9LRQAmKWiigBNq+lNMakH7wz6MRVO61ER3Qs7dVmvCnmeUX2hVzjcxwcDOccEnsDg4kSG7Yky3QA7CJMY+uc5P5fSnqA8WkasWVpcn1mcj8s4pWikYjE7qB6BefzFHlzLGAs2Wz96RQf5YppmliY+ZEWTH34+fzHX8s0tQHOlxtURSqGB5Lpuz+RFK5nEZ2KjSehbaD+ODT4pY541kidXQ9CpyKfQBXMsyBd0DMT1KMCB+eKct1G2/lgEPzFkKj8zU2KTA9KAGxypKoaN1ceqnIp9Qvawu27ywH6bl4P5jmmtHOh3RyBuPuP0/PqPxzQBYoqGCcSkoytHIv3kbGR6Hjgj/PWpqACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKTI9arXlp9rVVMsyBSG/dysmSORkqQSPbPNVbiSKxAzFDJcOfkVVCs34kn1Az79zxTSuBduLu3tkLzzxxKOpdwoH4mqFprkV1ciPCKjqzI/mqdwUr2HTO4Y7+oFMXT7i6R5r7y5ZCS0cBJ8qP0yMfMRxyc8jjFOxBa3AlXCW1pb7M5yeSMjHXICqfU7hVWja3UDRa5gjQM80agkAEsOSTgD86yEMusXaPKDFYoSfII5m6gbs84HXb64zzkKkCyalcm4m2hAwMSsAwiXHOMcM5HVuQM4GcMTsRxRwoEjGAox6/n3pfD6gJPLbxxgzyRqm7ALsAM/j3ppUK2VkdeM92H+fpiqWmpEjI12o/tIriR2yS2AN20n+DPOBgDPQGr1xNHEgLDLE7VXuzegpeQCC4bapVVlUgfNGw5/A/4mquo6zHaRIsKia6lOIrcttZucZIxkDtnHUgd6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8F0P/wATR/wgng//AKFTQ/8AwXQ//E10FFAHP/8ACCeD/wDoVND/APBdD/8AE0f8IJ4P/wChU0P/AMF0P/xNdBRQBz//AAgng/8A6FTQ/wDwXQ//ABNH/CCeD/8AoVND/wDBdD/8TXQUUAc//wAIJ4P/AOhU0P8A8F0P/wATWppuk6bo1u1vpen2ljAzl2jtYViUtgDJCgDOABn2FXKKACiiigCOeCG6t5be4ijmglQpJHIoZXUjBBB4II4xWH/wgng//oVND/8ABdD/APE10FFAHP8A/CCeD/8AoVND/wDBdD/8TR/wgng//oVND/8ABdD/APE10FFAHP8A/CCeD/8AoVND/wDBdF/8TSf8IH4P/wChV0P/AMF8X/xNdDRQBzX/AAr7wesZRPDGjr7/AGCJj+ZU0g8BeFgoH/CMaCcd202HJ/Jf6V01FAHNJ4F8KkHf4S0Bf92wiP8A7IKRfBfhHBMng7R4wOmdOhJP/fINdNRigDmT4O8EjG7wxoKk9A2nRKf1WpB4G8HtyPCuhkf9g6L/AOJrosD0qOSCKVdskaOPRhkUWQGGPAvg/wD6FXQv/BdD/wDE0f8ACCeD/wDoVND/APBdD/8AE1si1iRNiJ5a+kR2fypUt1jztaTn+87N/M0AYv8Awgng/wD6FTQ//BdD/wDE0f8ACCeD/wDoVND/APBdD/8AE1rm2lzkXkw9tqY/9BqRY3Uf61m/3sf0oAxP+EE8H/8AQqaH/wCC6H/4mkPgTwfj/kVdD/8ABfD/APE1tvFI4wJnT3UDP6g0jWiSLtlLSqRghjwfqOh/KgDm7fwT4Qmu5ynhfQ2hXCj/AIl8RG4Z3Y+Xp90fUHvmtOy8JeG9MvI7uw8P6VaXUedk0FnHG65BBwwAIyCR+Na4AHQUtAEUdtDC7NHEiFjklRjJ98daloooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACkzS0lAC0UCigAzRmkooAXNFJRQAtFJRQAtFJRQAtFJRQAtFJRQAtFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFJS0lAC0UUUAGKTFLRQAmKKWmeahbaGBbg4HXnp/I/lQA6kyM9efSsq98QWlvcLaQE3V65IW3gILZ4+92Uc5yewNV5op7m3NxrdwLW2BJFvDKUAHbe4OSw6YU4+tOw7Fy4vBeiaxtJZBNhleeFcrAcdz0z7Dn2FJ4evW1DQbS5kBEjLtfJySykqT+JGagt7l5YVj0aziFsvCzSEpG3+6AMt9eB9ao+GraWcXwvJZGa21CZY44yY0TkNwBjIJY9c0AdRRRRSEFFFFABS0gpaACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKSlpKAFooozQAUmap3Wp29tOtu295mG4RxoWIHqcdBnjJqn5Gq6jhpphYQbs+TH80rL7uDhT1+7nHrQFixd6xa285t1YzXfQW8Q3N7Zxwo5HLYrE1yLVWsPttyQlvAweSztWYNJGeGDODzgZPGB169a6Kz0+2sVYW0KoXbc7dWc5zlmPLHnqaNQtftlhcW+8xmWNo947ZGM00NOxnxaQbe4luNOktolmVeGg3AALjC4ZeMf19asW2lbDvu7mW9l3Bw0wXCMOhVQML/P3pnh6eKTRoYY2DG1H2aQg5G5AAcH07j2NatDYNsbjjqT9awbUfY/GF7C2dl9Ck6HHCsnysB742nP/wBaugrB8TbrW1t9VQHdYTrI2FyWjPyso/A5/ChAjdoqOCZZ4UlTOx1DLkEcH2qSkIKKKKAAUtAooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKw5/FmnW1xLA9trJeNyjGPRbx1JBxwyxEMPcEg9qj/wCEy0v/AJ9dc/8ABFe//GaAOgorn/8AhMtL/wCfXXP/AARXv/xmj/hMtL/59dc/8EV7/wDGaAOgorn/APhMtL/59dc/8EV7/wDGaP8AhMtL/wCfXXP/AARXv/xmgDoKK5//AITLS/8An11z/wAEV7/8Zo/4TLS/+fXXP/BFe/8AxmgDoKK5/wD4TLS/+fXXP/BFe/8Axmj/AITLS/8An11z/wAEV7/8ZoA6Ciuf/wCEy0v/AJ9dc/8ABFe//GaP+Ey0v/n11z/wRXv/AMZoA6Ciuf8A+Ey0v/n11z/wRXv/AMZo/wCEy0v/AJ9dc/8ABFe//GaAOgorn/8AhMtL/wCfXXP/AARXv/xmj/hMtL/59dc/8EV7/wDGaAOgorn/APhMtL/59dc/8EV7/wDGaP8AhMtL/wCfXXP/AARXv/xmgDoKK5//AITLS/8An11z/wAEV7/8Zo/4TLS/+fXXP/BFe/8AxmgDoKK5/wD4TLS/+fXXP/BFe/8Axmj/AITLS/8An11z/wAEV7/8ZoA6Ciuf/wCEy0v/AJ9dc/8ABFe//GaP+Ey0v/n11z/wRXv/AMZoA6Ciuf8A+Ey0v/n11z/wRXv/AMZo/wCEy0v/AJ9dc/8ABFe//GaAOgorn/8AhMtL/wCfXXP/AARXv/xmj/hMtL/59dc/8EV7/wDGaAOgorn/APhMtL/59dc/8EV7/wDGa0NM1m11fzfs0V9H5WN32uwnts5zjHmou7p2zjjPUUAaFFFFABRUc88Nrby3FxLHDBEheSSRgqooGSSTwABzmsP/AITvwf8A9DXof/gxh/8AiqAOgNJWAfHfg/8A6GvQ/wDwYw//ABVJ/wAJ34Q/6GvQ/wDwYw//ABVAHQ0ySJZUKMWAIwdrFT+Y5FYX/Cd+D/8Aoa9D/wDBjD/8VR/wnfhD/oa9D/8ABjF/8VQBpWulQWdssETSDaxbfu+ZjnOSR1/GroXHfNYH/Cd+EP8Aoa9D/wDBjF/8VR/wnfhD/oatD/8ABjD/APFUAdBSGuf/AOE78If9DXof/gxh/wDiqP8AhO/CH/Q16H/4MYf/AIqgB9qx0/xNd2WxjDdoLqMquFVvuuCfc4P4+9btcP4g8beGPIt7u18U6Q72k6TNHDfxF5EBwyj5u4PTvitaLx94PliSQeKtFAYZw1/Ep/EFsimNnRUjKHUqwyCMEVgf8J34Q/6GvQ//AAYw/wDxVH/Cd+EP+hr0P/wYw/8AxVIRftNLaxdUtruRbQEn7OyqwHsDjIH1z7YrRrn/APhO/CH/AENeh/8Agxh/+Ko/4Tvwh/0Neh/+DGH/AOKoA6Ciuf8A+E78If8AQ16H/wCDGH/4qj/hO/CH/Q16H/4MYf8A4qgDoRRXP/8ACd+D/wDoa9D/APBjD/8AFVYsfFnhvU7yOzsPEGlXd1JnZDBexyO2AScKDk4AJ/CgDYooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACkpaKACkpaKAEopaKAEopaKAGkAgg96jt7aG0hEMEaxxgkhV6DJycfiamooASilooASilxRigBKKXFGKAAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRUX2m33bfPi3em8ZqQEEAggg9CO9NprcBaKKKQBRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRTRIhbaGG7rtPBxnGcelDyLGBuYDJCj3JoAdRRRQBXvbj7LZzXBXcscbOwzjgAn+lZmm20l3HFeagXka5G8RM+6OMEZCBeh9d2M8Y9qreIrqW5uLXTLGfZLvE9ywb5VgXk7h3B4GO4PvWxpkr3GlWk0i4eSJHbPXJArRpwhzdWAf2VpxYt9gtdx6nyVz/KquoW726mew3pLAocxK2I3HTBHToD2qHUtWuoxJ/Z6RyCBcySvxHuHVPUnAJ4PHetG4uYbWKSaViQMjA+8TkYCgf5/orSWr1HYnjlV1Dhsqx+U461JXJaVd3dlr8tldFWtn8vaEA8u3dgxAX2bIAz6V1tKdPkduggoooqQCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooo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KKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooApTxPcuu2/nt/Lf5liEbBu/zblOP0qdYFEhZwXIxhnOefYdB+H9Kmop3AQeuME8mjAznAz60tFIAowBnjrRRQAhUMCGAIPBBpCoKkYHPqOKdSEBgQQCDwQaAMTR41s7u802PYq28pkhTPPlvhjgegbdz/k7YUAkgDJ6n1qleaXFdTRXCHyLqJgRMgwWAJOxu7ISc7c9eetXAGCqMjjrx1qpO7uO46jAznHNFFSIhlto52UyhmCnIXcQPxA4PTPOamoooAKAAOgoooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKD0oACQOtQm6txKYjNH5gGSu4Zx64qrA/8AaFxK+9vs8LmIJ2dhwxPqMkjHsfwuxxRxIqRoqqowAowAPSnawCR3EMxYRSo5X7wVgcfWpKguGtY0D3JiVFOd0hAAPrzUEcyCUiC5SZcFmjD7mHHBHP8AP168YosBeopkUqTRh0bKnvT6QBRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRR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AUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAY+s/8AIU8Pf9hB/wD0lnrYrH1n/kKeHv8AsIP/AOks9bFJAFFFFMDHtv8AkcdT/wCwfaf+jLiii2/5HHU/+wfaf+jLiikgNiiiimAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAZWsabe31xp81leW9u1nM02JrZpQ7GNkHR1wMO3449OWfZvEf/QV0r/wWSf8Ax+q/iTT7LUNS8Ppe2dvcr9udMTRK42m3mJHI6ZVT9VHpVj/hE/Dn/Qv6V/4Bx/4VPUYfZvEf/QV0r/wWSf8Ax+j7N4j/AOgrpX/gsk/+P0f8In4c/wChf0r/AMA4/wDCj/hE/Dn/AEL+lf8AgHH/AIUWYD9N029t9Tu7+/vLe4lnhihAgtmiVVQyHu7ZJ8w+nSiqmk6fZab4r1SGws7e1iaxtHKQRKilt9wM4A68D8qKaEdBRRRTAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAMfWf8AkKeHv+wg/wD6Sz1sVj63a6lPdaXPp8NpL9kuGncXFw0WcxPGAMI3/PQn/gPvwfafEf8A0CtK/wDBnJ/8YpAbFFY/2nxH/wBArSv/AAZyf/GKPtPiP/oFaV/4M5P/AIxRcAtv+Rx1P/sH2n/oy4oo0y11L+2b3UNQhtIPOt4IEjt7hpfuNKxJJRcf6wevSihAbFFFFMAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAxPFIuP7JhNte3Fm5vrVDJBt3FWnRCPmB4+bPvjByCQX/ANjX/wD0Muq/9+7X/wCM0eJf+QXB/wBhCy/9Koq2KVtQMf8Asa//AOhl1X/v3a//ABmj+xr/AP6GXVf+/dr/APGa2KKLAc/BBeWXiuzhl1e9vIpbG5cpOI1UMrwAHEaLk/MeucdsZOSrFz/yOOmf9g+7/wDRlvRQgNiiiimAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAYnimQx6TCRDcSn7davtggeVgqTo7HCAnAVWP6dSKf8A8JLYf88NV/8ABTdf/G6Z4pjMmkwgTXER+3WqboJ3iYq86IwyhBwVZh+vUCn/APCNWH/PfVf/AAbXX/xyp1voMP8AhJbD/nhqv/gpuv8A43R/wkth/wA8NV/8FN1/8bo/4Rqw/wCe+q/+Da6/+OUf8I1Yf899V/8ABtdf/HKNQIbe4GqeJbW7t4LtYLeznike4tZIMM7wlQBIqluI26ZxjnGRkpsFkmm+K7OG3uL1oprG5d0nvJZlLK8AU4djgjc3T1opoR0FFFFMAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAx/Ev8AyC4P+whZf+lUVbFY/iSO6l0yFLSzlu5BeW0pSJkUhY5VkY/OyjohHXqR2yQf2zf/APQtar/38tf/AI9S6gbFFY/9s3//AELWq/8Afy1/+PUf2zf/APQtar/38tf/AI9RcAuf+Rx0z/sH3f8A6Mt6Kht2vr7xLa3cuk3dlBBZzxM9w8J3M7wkABHY9EbriihAb1FFFMAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAxPFMZk0mECa4iP261TdBO8TFXnRGGUIOCrMP16gU/wD4Rqw/576r/wCDa6/+OUeJf+QXB/2ELL/0qirYpW1Ax/8AhGrD/nvqv/g2uv8A45R/wjVh/wA99V/8G11/8crYoosgOfgsk03xXZw29xetFNY3Luk95LMpZXgCnDscEbm6etFWLn/kcdM/7B93/wCjLeihAbFFFFMAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA5bx/rVtoWgW9zdJK6NqFtgRAE/JIJT1I/hjYfUj61g/8Lp8Of8APlqv/fqP/wCLoorGc3GWhSV0H/C6fDn/AD5ar/36j/8Ai6P+F0+HP+fLVf8Av1H/APF0UVHtZD5UavhrxRZeM9f+36dFcRRafayQyi4VVZmmaMrt2k8DyWznHUdecFFFbwd1cl7n/9k=" id="p25img1"></div>


    <div class="dclr"></div>
    <div>
    <div id="id25_1">
    <p class="p212 ft42">Código: FG-SSO-01</p>
    <p class="p213 ft42">Revisión:00</p>
    <p class="p214 ft58">PROGRAMA DE INDUCCIÓN PARA PERSONAL NUEVO O</p>
    <p class="p215 ft58">TRANSFERIDO</p>
    <p class="p216 ft58">Hoja de Ruta para Trabajadores Nuevos</p>
    <table cellpadding=0 cellspacing=0 class="t22">
    <tr>
        <td class="tr10 td183"><p class="p217 ft45">Apellidos y Nombres:</p></td>
        <td class="tr10 td184"><p class="p162 ft45">Fecha de Ingreso:</p></td>
    </tr>
    <tr>
        <td class="tr35 td185"><p class="p192 ft45">RUFINO ALAMA, LUIS</p></td>
        <td class="tr35 td186"><p class="p162 ft45">03 de Junio del 2020</p></td>
    </tr>
    <tr>
        <td class="tr37 td187"><p class="p55 ft124">&nbsp;</p></td>
        <td class="tr37 td188"><p class="p55 ft124">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr13 td185"><p class="p217 ft45">Puesto de Trabajo:</p></td>
        <td class="tr13 td186"><p class="p162 ft45">Firma:</p></td>
    </tr>
    <tr>
        <td class="tr1 td185"><p class="p218 ft41">OBRERO DE CAMPO</p></td>
        <td class="tr1 td186"><p class="p55 ft59">&nbsp;</p></td>
    </tr>
    <tr>
        <td class="tr38 td187"><p class="p55 ft125">&nbsp;</p></td>
        <td class="tr38 td188"><p class="p55 ft125">&nbsp;</p></td>
    </tr>
    </table>
    <p class="p219 ft48">Recursos Humanos/Administración</p>
    <p class="p220 ft49">Nombre del Instructor:</p>
    <p class="p221 ft45">VILELA LUDEÑA OLGA STEFFANA</p>
    <p class="p222 ft48">Seguridad y Salud en el Trabajo</p>
    <p class="p220 ft49">Nombre del Instructor:</p>
    <p class="p223 ft45">REYES TINOCO JOSE LENIN</p>
    <p class="p224 ft48">BPA</p>
    <p class="p220 ft49">Nombre del Instructor:</p>
    <p class="p225 ft45">SALAZAR CAMPOS KARLA MAGALY</p>
    <p class="p224 ft48">Jefe de Campo</p>
    <p class="p220 ft49">Nombre del Instructor:</p>
    <p class="p226 ft45">GALINDO CARRION REMO YUNIOR</p>
    <p class="p227 ft48">1.- Recursos Humanos/Administración</p>
    <p class="p228 ft49">Puntos a Considerar:</p>
    <p class="p229 ft49"><span class="ft89">∙</span><span class="ft126">Giro o actividad principal de la Empresa y sus principales clientes.</span></p>
    <p class="p229 ft49"><span class="ft89">∙</span><span class="ft126">Reseña Histórica de la Empresa</span></p>
    <p class="p229 ft49"><span class="ft89">∙</span><span class="ft126">Filosofía de la Empresa: Misión, Visión y valores organizacionales</span></p>
    <p class="p230 ft49"><span class="ft89">∙</span><span class="ft126">Planillas, Horarios Laborales, Boletas y Beneficios Sociales (días de descanso, días de pago, prestaciones de servicio personal, etc.)</span></p>
    <p class="p229 ft49"><span class="ft89">∙</span><span class="ft126">Organigrama y Departamentalización.</span></p>
    <p class="p228 ft49"><span class="ft89">∙</span><span class="ft126">Reglamento Interno del Trabajador.</span></p>
    <p class="p229 ft49"><span class="ft89">∙</span><span class="ft126">Medidas Disciplinarias.</span></p>
    </div>
    <div id="id25_2">
    <p class="p231 ft89">Devolver este formato debidamente firmado al Área de RRHH o Administración</p>
    <p class="p232 ft45"><span class="ft41">2.</span><span class="ft127">INDUCCCION GENERAL EN SEGURIDAD Y SALUD EN EL TRABAJO. </span><span class="ft44">Puntos a considerar:</span></p>
    <p class="p233 ft44"><span class="ft128">∙</span><span class="ft129">Importancia del trabajador en el Sistema de Gestión de SST.</span></p>
    <p class="p234 ft44"><span class="ft128">∙</span><span class="ft129">Reglamento Interno de Seguridad y Salud en el Trabajo.</span></p>
    <p class="p234 ft44"><span class="ft128">∙</span><span class="ft129">Políticas de SST, Deberes y Derechos.</span></p>
    <p class="p234 ft44"><span class="ft89">∙</span><span class="ft130">Reglas Generales de SST de acuerdo a la identificación de Peligros y evaluación de</span></p>
    <p class="p235 ft49">Riesgos, reporte, investigación y elaboración de informes de incidentes accidentes de SST.</p>
    <p class="p236 ft49"><span class="ft89">∙</span><span class="ft131">Equipos de protección personal y equipo de protección colectivo: uso y mantenimiento.</span></p>
    <p class="p234 ft49"><span class="ft89">∙</span><span class="ft131">Orden y Limpieza.</span></p>
    <p class="p234 ft49"><span class="ft89">∙</span><span class="ft131">Comentarios generales de Primeros auxilios</span></p>
    <p class="p10 ft45"><span class="ft41">3.</span><span class="ft127">BPA</span></p>
    <p class="p234 ft49"><span class="ft89">∙</span><span class="ft131">Inocuidad</span></p>
    <p class="p234 ft49"><span class="ft89">∙</span><span class="ft131">Manipulación de producto en pre recolección (introducción especial).</span></p>
    <p class="p233 ft49"><span class="ft89">∙</span><span class="ft131">Cuidado del Medio Ambiente y conservación.</span></p>
    <p class="p237 ft49"><span class="ft89">∙</span><span class="ft131">Gestión de Residuos y contaminantes, reciclaje y reutilización (introducción especial).</span></p>
    <p class="p236 ft49"><span class="ft89">∙</span><span class="ft131">Fertilización, fertirrigación y Riego (Salud, Seguridad y bienestar del trabajador).</span></p>
    <p class="p234 ft49"><span class="ft89">∙</span><span class="ft131">Mejora del sistema de calidad</span></p>
    <p class="p10 ft134"><span class="ft132">4.</span><span class="ft133">JEFE DE CAMPO/SUPERVISOR</span></p>
    <p class="p238 ft49">Puntos a Considerar:</p>
    <p class="p234 ft49"><span class="ft89">∙</span><span class="ft131">Explicación de las expectativas del Jefe o Supervisor inmediato</span></p>
    <p class="p234 ft49"><span class="ft89">∙</span><span class="ft131">Identificación de Peligros y Evaluación de Riesgos en su área del trabajo.</span></p>
    <p class="p23 ft48"><span class="ft48">5.</span><span class="ft135">Almacén</span></p>
    <p class="p239 ft49">Entrega de Equipos de Protección personal</p>
    <p class="p234 ft49"><span class="ft89">∙</span><span class="ft131">Casco de seguridad.</span></p>
    <p class="p240 ft137"><span class="ft136">∙ </span>Zapatos de seguridad <span class="ft136">∙ </span>Uniforme</p>
    <p class="p241 ft49"><span class="ft89">∙ </span>Guantes de seguridad</p>
    <p class="p242 ft137"><span class="ft136">∙ </span>Tapones auditivos/Orejeras <span class="ft136">∙ </span>Respirador</p>
    <p class="p241 ft49"><span class="ft89">∙ </span>Lentes de Seguridad</p>
    <p class="p243 ft49">………………………………………………………………………………………………………</p>
    </div>
    </div>
    </div>
    <div id="page_26">


    </div>
    <div id="page_27">


    <div id="id27_1">
    <p class="p6 ft30">______________________________________</p>
    </div>
    <div id="id27_2">
    <p class="p6 ft138">RUFINO ALAMA LUIS</p>
    <p class="p244 ft139">DNI: 73273262</p>
    </div>
    </div>
    <div id="page_28">


    </div>
    <div id="page_29">
    <div id="p29dimg1">
    <img src="data:image/jpg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAOWAxoDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD3+iiigAooooAKKKKAEooooAKxdf8AF2g+F4g+sanBbMwykRO6R/8AdQZY/lVfUf7c1qZrTTJjpVgp2y37IGmk9RCp4Uf7bfgD1p+i+C9B0KU3FrZCW+c5kvbpjNcSH1MjZP5YFaKMVrL7kI5Sf4m63qOR4Y8C6veofu3F2v2eM+4znI/EVQfVPjTfHMOhaNYIegaRWI+v7w/yr1mirVWK2gvndhY8kC/G1fmL6I3+ydv+FSr4i+L2m/NfeEtN1CMdTazBWP8A4+f5V6tRR7dPeC+7/ghY8yt/jLZWcqweKPD+raDITjfPAXj/ADwD+Qrv9J1rTNdsxd6VfQXkB/jhcNg+h9D7Grc0MVxE0U0aSRsMMjqCCPcGuPvPhpov206jobT6BqXa405tit7NGfkYe2KTdKXS34r/ADDU7OisHTbzWrFltdehin7JqFmpEb/9dIzkxn6Er7jpW9WTVhgKWkFLSAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAKuoTS22mXU8Cb5o4XdE/vMASB+dfOngvxNrZ8fafMb64nkvLlY7hXckSKxwcjpwDkemK3vGPxv1/w54v1PSLbTdNkhtJvLR5Fk3EYB5wwHeuOtPiff6TqL61beDdHt7iTJ+0eTMFGeu3L4XPtitZ5biKnLKNkvU9HA4+jh6VWFSF3Jafj/wAOfU9FeVfDP4vnxnqj6PqlnDa35UyQNATskA5K4JJBA568gHpjn1WlVpSpS5ZrU81O4UUUVmMKKKKACiimPNFGQJJEQnpuYDNAD6KK848a/FCbwl4gOmJpSXIESyeYZyvXPGNp9Kmc4wV5G+Hw1XEz9nSV2ejilqlpF8dT0axv2jEZubdJigOdu5QcZ79au1Sd9TGUXFuL6BRRRQIKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA+PPimMfE7X/8Ar5/9lFd5qXxx0648DtoVvoc0kz2ItGe4dfLHybS2Bkn1HSuE+Kwx8UNe/wCu4/8AQFruvFPgG31P4N6D4k062RNQsrCN7ny1A86LHJOOpXrn0z7V7slTcKXtPL8jLXWxn/Avwjql34ut/ET27xabZrJiZxgSuylQq+uNxJPTiu0+JV38T73WZLLw1p93baTFhVntXQSTnHLE5yozwBx0yfbkvgb48uNP1xPDOoXLvYXny2vmNkQy9Qo9A3Ix649TXPfEzxnret+NNS0+6vri10+1unt47ZGKoqq23cyj7xOM8+vFZyp1J4p3S0XXt/mO6US14rsvFvgi3tbufx6bi9lfa9rbalI8kZxnJBPI7Z9SK9O+GfjjVvFPw/11tSm332nRuqXKjazAxkqTj+IEHke1eT+OdG8B6LoFjB4a1SXVdVkkDz3HmZVY9pyCAAASxXA5Iwc12PwP/wCRH8Zf9c//AGm9RioxlhXNrX0sXR/ixXmvzRi6H4t8Y3F/9h0/VL25u7xPIjWSYvtyQSV3HAOAeewJpb/VPGfg/XvJvNUvorxQJNr3BlRwehwSQwrM8JazF4e8U2GqzxvJFbuS6pjcQVKnGfrWn8RPFNr4t8SLe2UUiW8UCwoZQAzYJJJA6ctj8K+T5vcvzan6E6X+0qCpLka1dlv0R6Lr3xOuF+HGn6nZKsOp6gzQkgZETJw7DP4Y/wB72rifD3gW88Z6bLrF5r8MMruyoLli7yEdSSTwM/Wl1jw9fQ/CTQ79om2JcyyyDHKpJgKx9jsH/fQrL8O23gq402RvEF9qdteox2rbqGSRe2PlOD168VpKTlJc/b0OOhRp0aE3hnZ8zV0uZ77W7HQ/DjxdqWg+KY/D1/cNNZTTG22M+4RSZwCh9CeMdOc1V+Mn/I+N/wBesf8AWn+E9P8ACWreKLC30y08Qm5WVZQ7zQ7ECnO5sL04/pTPjJ/yPjf9esf9aHf2LTfUKap/2kpRjZuLvpbtruz2/wAJ/wDIoaL/ANeMP/oArYrH8J/8ihov/XjD/wCgCtivQj8KPj6/8WXq/wA2FFFFUZBRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFAHI6t8MvB+t6lPqOo6Mk13O26SXzpFLHGOgYDtXQ2elWVhpEWlW9uq2MUXkLCxLDZjGDnrx61dxRiqc5NWbCxxkPwo8DwTxzw6DEksbB0dZpQVYHII+apPEnwy8KeKr03upad/pZADTwSGNnx/exwfqRmuvxRiq9tUvfmdxWRxlp8K/B1lot3pUWkL5F2FE7tIxkcKwYDfnIGQDgYFOt/BmheD/AAzrqaJaPbrc2rmUNM75Ko2PvE46muxxSEAjBpSqTkmm3qVBqMlLsfNvwv0qy1nxa1hqNsk9tLaybkb8MEHqD7ivXLL4T+ErK7W4+xSzlTlY55SyD8O/45rtFiRTlUUH1Ap+K5adCMVZ6nqYzNa1eo5U24pq1kyKW3hmt2t5YkeFl2NGygqV9CPSuHu/hB4TurgypBc24JyUhmIX8iDiu9xRitZQjL4kcFHE1qN/ZSav2MXQPC2jeGYGi0qzWEv9+Qks7/Vjz+HSsvxF8OdD8T6qdR1A3XnlBH+6lCjA6cY9667FGKHCLXLbQccVWjUdVTfM+vUrWFnFp2n21jBu8m3iWJNxydqgAZP4VZooqjFtt3YUUUUCCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAoo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JOeeor0migDhdV+H95qt5qjPr7x2up+Q1zCtqp3vEqgHdnIB25wPX84z8L7NrG9he/m+0ST+ZazruH2ZVwI127sNtAIzx17V31FAHBD4bu0l3by6y50m6uzePZJbKCZDjq+SSMDGABW3rPg7Ttd1Rb29M5Zbc24WOVk4JyeQfcjFdFRQBwV18OZ5LKCG11lYZFtRZzvLZLKtxEp/dhkJwCuBz1Ptiq9t8J7RZbP7bqBuoIbN7WSLyAm8mRpAwIbK4LdvTk16LRQBwb/Dy4u7hLzUNce41CGzjgguVthGUmjkZ0mwGIJGQNvQ4z3q7J4Mvr7TpYtW8Qz3t6JkntbpbdYvssiD5WVF4PvnrXX0UAefv8Nri5gv5bzXpLjVLuaGUXrW4HlmM5ACBsEfiO3pysnw3n1XVLa78Ta/Jq8durKsIthbgg+pRs9efU9K7+igDGbw3ZSaJFpMm97WOVZFVjnAV94U+q54+lZWpeANP1LULidp54ba6kilubSLAjmaPgZ4yMjg4I9a66igDmbbwJodjIzWdu9ujywzGKN/k3Rk7SAc4+8QfWr+r6F/al1Z3Ud9c2dxal9ksG3JVgNwwwI7DnFa9FAHLr4MT+0bfUJdY1SW6gieFZDIoYoxB2khecEZq/qHhy21I2Us090t1ZkmG5il2SDOA2ccHIAByO1bNFAHNTeCNKl0+WwDXiW0qbJUW4bEmXDszA9WLdT6Eip7nwho9xcy3CQSW0ssAt3a1laHKBtw+4Rznv1reooA56fwXotxqiahJbzectwt0UW4kEZlXlXKA7cjA7c962LKxgsInjt1dUeRpSGkZ/mYkscsTgZPToO1WaKACiiigApB1/ClpB1/CgBaKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooA8f/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigA/4aO8H/APQN1z/vxD/8do/4aO8H/wDQN1z/AL8Q/wDx2iigD//Z" id="p29img1"></div>


    <div class="dclr"></div>
    <table cellpadding=0 cellspacing=0 class="t23">
    <tr>
        <td class="tr4 td30"><p class="p55 ft140">&nbsp;</p></td>
        <td class="tr4 td189"><p class="p55 ft140">&nbsp;</p></td>
        <td class="tr4 td113"><p class="p245 ft1">MEMORÁNDUM N° 001-2020-G.GRAL./RAPEL</p></td>
    </tr>
    <tr>
        <td class="tr39 td30"><p class="p55 ft141">A</p></td>
        <td class="tr39 td189"><p class="p246 ft141">:</p></td>
        <td class="tr39 td113"><p class="p130 ft141">TODO EL PERSONAL</p></td>
    </tr>
    <tr>
        <td class="tr32 td30"><p class="p55 ft141">DE</p></td>
        <td class="tr32 td189"><p class="p246 ft141">:</p></td>
        <td class="tr32 td113"><p class="p130 ft141">GERENCIA GENERAL</p></td>
    </tr>
    <tr>
        <td class="tr32 td30"><p class="p55 ft141">ASUNTO</p></td>
        <td class="tr32 td189"><p class="p246 ft141">:</p></td>
        <td class="tr32 td113"><p class="p130 ft141">ENTREGA DE BOLETA DIGITAL</p></td>
    </tr>
    <tr>
        <td class="tr40 td30"><p class="p55 ft141">FECHA</p></td>
        <td class="tr40 td189"><p class="p246 ft141">:</p></td>
        <td class="tr40 td113"><p class="p130 ft141">03 de Junio del 2020</p></td>
    </tr>
    </table>
    <p class="p247 ft142">Por medio de la presente, tenemos a bien a comunicarnos con usted con la finalidad de informarle lo siguiente:</p>
    <p class="p248 ft144">Que en ejercicio de nuestro poder de dirección y al amparo de lo que establece el artículo 3° numeral 3.2° Decreto Legislativo Nº 1310, Decreto Legislativo que aprueba medidas adicionales de simplificación administrativa y demás normas complementarias; a partir del mes de junio, La Empresa realizará la entrega de sus boletas de pago de remuneraciones en forma digital, las cuales pondremos a su disponibilidad a través de la <span class="ft143">Plataforma</span></p>
    <p class="p249 ft141"><span class="ft145">“rapel.turecibo.com”</span>.</p>
    <p class="p250 ft144">Las boletas de pago serán puestas a su disposición en la plataforma virtual, de manera mensual, a más tardar el tercer día hábil siguiente a la fecha de pago de la remuneración, siendo su obligación acusar recibo de la boleta de pago en la plataforma virtual dentro del día hábil siguiente de recibida. En caso de incumplimiento de esta obligación, la Empresa podrá aplicar las sanciones disciplinarias que considere pertinentes.</p>
    <p class="p251 ft142">Asimismo, le informamos que para poder acceder a la plataforma en mención, el área de Recursos Humanos le hará entrega de su usuario y clave en el desglosable de este documento.</p>
    <p class="p252 ft142">Atentamente,</p>
    <p class="p253 ft142">_________________________________</p>
    <p class="p254 ft146">_____________________________</p>
    <p class="p255 ft147">Nombre: RUFINO ALAMA LUIS</p>
    <p class="p256 ft147">DNI: 73273262</p>
    <p class="p255 ft147">Fecha de recepción: 03 de Junio del 2020</p>
    <table cellpadding=0 cellspacing=0 class="t24">
    <tr>
        <td class="tr35 td190"><p class="p55 ft148">USUARIO:</p></td>
        <td class="tr35 td191"><p class="p257 ft147">73273262</p></td>
        <td class="tr35 td192"><p class="p55 ft149">CLAVE:</p></td>
        <td class="tr35 td193"><p class="p46 ft141">06/10/1997</p></td>
    </tr>
    </table>
    <p class="p258 ft152"><span class="ft150">RECUERDA: </span>La primera vez que ingreses, deberás cambiar la contraseña por una de tu elección y de fácil recordación. Como mínimo debe tener 8 dígitos. <span class="ft151">No olvides firmar tu boleta, es tu obligación.</span> Para cualquier consulta, acércate a la oficina de Recursos Humanos de tu fundo.</p>
    <p class="p259 ft146"><span class="ft147">Página Web: </span>rapel<span class="ft147">.</span>turecibo.com</p>
    </div>
    <div id="page_30">


    </div>
@endsection
