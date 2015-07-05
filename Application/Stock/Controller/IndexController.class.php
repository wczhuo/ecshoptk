<?php
namespace Stock\Controller;
use Think\Controller;

class IndexController extends Controller {
    public function index(){        
        $this->display();
    }
    public function convert(){
        ob_end_clean();
        header("Content-Type:text/html;charset=utf8;");
        ob_start();
        set_time_limit(0);
        $Min=I('min');
        $Max=I('max');
        if(!(is_numeric($Min)&&is_numeric($Max)&&($Min<=$Max)&&($Min<=3000))){ 
            $OutputInfo=json_encode(array('msg'=>'参数不正确！'.$i,'url'=>U('Stock/Index/Index'),'autoClose'=>'1','type'=>'1'));
            echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;
        }
        $ReturnInfo=$this->ConvertStockPrice($Min,$Max);
        if($ReturnInfo==1){                   
            $OutputInfo=json_encode(array('msg'=>'参数不正确！'.$i,'url'=>U('Stock/Index/Index'),'autoClose'=>'1','type'=>'1'));
            echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;
        }else{  
            $Header='Location:http://localhost'.U('Stock/Index/Convert/?type=match&min='.$Max.'&max='.($Max+50));
            $Url=U('Stock/Index/Convert/?type=match&min='.($Max+1).'&max='.($Max+50));  
            echo '<script>location.href="'.$Url.'";</script>';die;
            header($Header);//return;die;
            $Url=U('Stock/Index/Convert/?type=match&min='.($Max+1).'&max='.($Max+50));            
            $OutputInfo=json_encode(array('msg'=>'添加成功，操作结束！'.$i,'url'=>$Url,'autoClose'=>'1','type'=>'1'));
            echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;
        }
    }
    private function ConvertTeam($Min=null,$Max=null){        
        if(is_numeric($Min)&&is_numeric($Max)&&($Min<=$Max)){            
            for($i=$Min;$i<=$Max;$i++){
                if(file_exists(ROOT_PATH.'/Stock/'.$i.'.html')&&(!M('team')->where(array('old_id'=>$i))->select())){ 
                    echo '<script>parent.PostReturnCallback(\''.'正在添加！'.$i.'\');</script>';  
                    ob_flush();
                    flush();  
                    ob_end_flush();
                    $CountData=M('match')->where(array('team_id'=>$i))->count();
                    M('match')->where(array('team_id'=>$i))->delete();
                    if(!$CountData){                        
                        $Content=@file_get_contents(ROOT_PATH.'/Stock/'.$i.'.html');
                        $ContentJson=json_decode($Content,true);
                        $TeamID=M('team')->add(array('old_id'=>$ContentJson['tid']));
                    }
                }
            }        
            return 2;
        }else{
            return 1;
        }
    }
    private function ConvertStockPrice($Min=null,$Max=null){ 
        $StockDataDir=opendir(ROOT_PATH.'/Stock/data/');
        $ConvertedFileCount=0;
        while (($file=readdir($StockDataDir))&&($ConvertedFileCount<$Max)) {
            $fullpath=CACHE_PATH."/".$file;
            if(!is_dir($fullpath)) {
                $ConvertedFileCount++;
                echo '<script>parent.PostReturnCallback(\''.'正在添加！'.$file.'\');</script>';  
                ob_flush();
                flush();  
                ob_end_flush();                     
                //$Content='[{symbol:"sh601588",code:"601588",name:"北辰实业",trade:"6.23",pricechange:"0.570",changepercent:"10.071",buy:"6.23",sell:"0.00",settlement:"5.66",open:"6.23",high:"6.23",low:"6.23",volume:3457900,amount:21542717,ticktime:"15:03:06",per:38.938,pb:1.924,mktcap:2097653.46,nmc:1657180,turnoverratio:0.13},{symbol:"sz000616",code:"000616",name:"海航投资",trade:"5.25",pricechange:"0.480",changepercent:"10.063",buy:"5.25",sell:"0.00",settlement:"4.77",open:"5.25",high:"5.25",low:"5.25",volume:473151,amount:2484043,ticktime:"15:05:54",per:35,pb:1.782,mktcap:750873.073125,nmc:750868.869975,turnoverratio:0.03308},{symbol:"sz300116",code:"300116",name:"坚瑞消防",trade:"10.180",pricechange:"0.930",changepercent:"10.054",buy:"10.180",sell:"0.000",settlement:"9.250",open:"10.180",high:"10.180",low:"10.180",volume:13877137,amount:141269255,ticktime:"15:05:54",per:285.154,pb:3.66,mktcap:339494.59132,nmc:165659.4963,turnoverratio:8.52769},{symbol:"sh601918",code:"601918",name:"国投新集",trade:"10.62",pricechange:"0.970",changepercent:"10.052",buy:"10.62",sell:"0.00",settlement:"9.65",open:"9.99",high:"10.62",low:"9.69",volume:173376399,amount:1784527355,ticktime:"15:03:06",per:1770,pb:3.588,mktcap:2751155.3916,nmc:2751155.3916,turnoverratio:6.69267},{symbol:"sz000507",code:"000507",name:"珠海港",trade:"12.71",pricechange:"1.160",changepercent:"10.043",buy:"12.71",sell:"0.00",settlement:"11.55",open:"12.19",high:"12.71",low:"11.75",volume:147578090,amount:1826664491,ticktime:"15:05:54",per:585.714,pb:4.098,mktcap:1003506.508049,nmc:981394.741838,turnoverratio:19.11277},{symbol:"sh600157",code:"600157",name:"永泰能源",trade:"8.44",pricechange:"0.770",changepercent:"10.039",buy:"8.44",sell:"0.00",settlement:"7.67",open:"8.00",high:"8.44",low:"7.98",volume:425236354,amount:3534271858,ticktime:"15:03:06",per:31.306,pb:2.979,mktcap:7267904.445204,nmc:2983640.48664,turnoverratio:12.02891},{symbol:"sh600731",code:"600731",name:"湖南海利",trade:"11.95",pricechange:"1.090",changepercent:"10.037",buy:"11.95",sell:"0.00",settlement:"10.86",open:"10.75",high:"11.95",low:"10.70",volume:16395656,amount:187439626,ticktime:"15:03:06",per:385.484,pb:5.389,mktcap:391140.34711,nmc:305505.474815,turnoverratio:6.41324},{symbol:"sz002509",code:"002509",name:"天广消防",trade:"16.34",pricechange:"1.490",changepercent:"10.034",buy:"16.34",sell:"0.00",settlement:"14.85",open:"16.34",high:"16.34",low:"16.34",volume:66624,amount:1088636,ticktime:"15:05:54",per:58.357,pb:4.974,mktcap:745824.902826,nmc:377489.026424,turnoverratio:0.02884},{symbol:"sh601069",code:"601069",name:"西部黄金",trade:"20.96",pricechange:"1.910",changepercent:"10.026",buy:"20.96",sell:"0.00",settlement:"19.05",open:"18.75",high:"20.96",low:"18.55",volume:32769673,amount:653195163,ticktime:"15:03:06",per:136.281,pb:9.404,mktcap:1333056,nmc:264096,turnoverratio:26.00768},{symbol:"sz000576",code:"000576",name:"广东甘化",trade:"17.45",pricechange:"1.590",changepercent:"10.025",buy:"17.45",sell:"0.00",settlement:"15.86",open:"15.88",high:"17.45",low:"15.74",volume:42164822,amount:704931237,ticktime:"15:05:54",per:872.5,pb:7.574,mktcap:772793.01038,nmc:446991.02991,turnoverratio:16.46065},{symbol:"sz002478",code:"002478",name:"常宝股份",trade:"17.45",pricechange:"1.590",changepercent:"10.025",buy:"17.45",sell:"0.00",settlement:"15.86",open:"16.70",high:"17.45",low:"16.70",volume:29393534,amount:510159762,ticktime:"15:05:54",per:28.607,pb:2.445,mktcap:698174.5,nmc:488815.079975,turnoverratio:10.49307},{symbol:"sh601390",code:"601390",name:"中国中铁",trade:"18.00",pricechange:"1.640",changepercent:"10.024",buy:"18.00",sell:"0.00",settlement:"16.36",open:"16.29",high:"18.00",low:"16.02",volume:1094350230,amount:19294382071,ticktime:"15:03:06",per:37.344,pb:3.884,mktcap:38339820,nmc:30766518,turnoverratio:6.40251},{symbol:"sz000061",code:"000061",name:"农 产 品",trade:"18.44",pricechange:"1.680",changepercent:"10.024",buy:"18.44",sell:"0.00",settlement:"16.76",open:"16.80",high:"18.44",low:"16.60",volume:63498183,amount:1124313067,ticktime:"15:05:54",per:276.877,pb:6.46,mktcap:3129201.857564,nmc:2960905.95028,turnoverratio:3.95455},{symbol:"sz000517",code:"000517",name:"荣安地产",trade:"24.48",pricechange:"2.230",changepercent:"10.022",buy:"24.48",sell:"0.00",settlement:"22.25",open:"24.48",high:"24.48",low:"24.48",volume:1588016,amount:38874632,ticktime:"15:05:54",per:57.156,pb:7.449,mktcap:2598080.74776,nmc:2571992.59536,turnoverratio:0.15115},{symbol:"sz002298",code:"002298",name:"鑫龙电器",trade:"15.92",pricechange:"1.450",changepercent:"10.021",buy:"15.92",sell:"0.00",settlement:"14.47",open:"15.92",high:"15.92",low:"15.92",volume:415813,amount:6619743,ticktime:"15:05:54",per:439.779,pb:5.145,mktcap:658846.4936,nmc:555523.132072,turnoverratio:0.11916},{symbol:"sz000065",code:"000065",name:"北方国际",trade:"28.88",pricechange:"2.630",changepercent:"10.019",buy:"28.88",sell:"0.00",settlement:"26.25",open:"26.37",high:"28.88",low:"26.37",volume:21689205,amount:605374942,ticktime:"15:05:54",per:39.562,pb:7.624,mktcap:731824.707416,nmc:731824.707416,turnoverratio:8.55921},{symbol:"sh603003",code:"603003",name:"龙宇燃油",trade:"23.94",pricechange:"2.180",changepercent:"10.018",buy:"23.94",sell:"0.00",settlement:"21.76",open:"23.94",high:"23.94",low:"23.94",volume:85981,amount:2058385,ticktime:"15:03:06",per:654.098,pb:6.143,mktcap:483588,nmc:153482.5719,turnoverratio:0.13411},{symbol:"sz000968",code:"000968",name:"煤 气 化",trade:"12.08",pricechange:"1.100",changepercent:"10.018",buy:"12.08",sell:"0.00",settlement:"10.98",open:"11.98",high:"12.08",low:"11.50",volume:42373066,amount:507478561,ticktime:"15:05:54",per:-6.238,pb:3.387,mktcap:620606.376,nmc:620606.376,turnoverratio:8.24785},{symbol:"sh601989",code:"601989",name:"中国重工",trade:"13.07",pricechange:"1.190",changepercent:"10.017",buy:"13.07",sell:"0.00",settlement:"11.88",open:"12.08",high:"13.07",low:"12.00",volume:1313807423,amount:16795510845,ticktime:"15:03:06",per:65.35,pb:4.061,mktcap:23998696.241262,nmc:23470917.196008,turnoverratio:7.31606},{symbol:"sz000547",code:"000547",name:"闽福发Ａ",trade:"26.25",pricechange:"2.390",changepercent:"10.017",buy:"26.25",sell:"0.00",settlement:"23.86",open:"26.25",high:"26.25",low:"26.25",volume:1550444,amount:40699155,ticktime:"15:05:54",per:114.13,pb:10.93,mktcap:2490037.16325,nmc:2191471.65825,turnoverratio:0.18572},{symbol:"sz002208",code:"002208",name:"合肥城建",trade:"22.74",pricechange:"2.070",changepercent:"10.015",buy:"22.74",sell:"0.00",settlement:"20.67",open:"20.70",high:"22.74",low:"20.68",volume:19838479,amount:433041424,ticktime:"15:05:54",per:42.111,pb:4.885,mktcap:727907.4,nmc:720230.635236,turnoverratio:6.26365},{symbol:"sh600962",code:"600962",name:"国投中鲁",trade:"17.80",pricechange:"1.620",changepercent:"10.012",buy:"17.80",sell:"0.00",settlement:"16.18",open:"16.49",high:"17.80",low:"16.45",volume:29097871,amount:501710279,ticktime:"15:03:06",per:-49.832,pb:5.533,mktcap:466733.8,nmc:452155.6,turnoverratio:11.45495},{symbol:"sz300059",code:"300059",name:"东方财富",trade:"35.600",pricechange:"3.240",changepercent:"10.012",buy:"35.600",sell:"0.000",settlement:"32.360",open:"35.600",high:"35.600",low:"35.600",volume:895739,amount:31888308,ticktime:"15:05:54",per:259.854,pb:29.906,mktcap:6028646.4,nmc:4579068.25568,turnoverratio:0.06964},{symbol:"sh601299",code:"601299",name:"中国北车",trade:"38.46",pricechange:"3.500",changepercent:"10.011",buy:"38.46",sell:"0.00",settlement:"34.96",open:"38.46",high:"38.46",low:"38.46",volume:29419024,amount:1131455663,ticktime:"15:03:06",per:80.125,pb:9.663,mktcap:47151115.045338,nmc:38944918.690938,turnoverratio:0.29053},{symbol:"sh601919",code:"601919",name:"中国远洋",trade:"9.67",pricechange:"0.880",changepercent:"10.011",buy:"9.67",sell:"0.00",settlement:"8.79",open:"9.05",high:"9.67",low:"9.05",volume:107644992,amount:1027310477,ticktime:"15:03:06",per:241.75,pb:4.052,mktcap:9879137.303219,nmc:7383697.103219,turnoverratio:1.40976},{symbol:"sz000410",code:"000410",name:"沈阳机床",trade:"20.55",pricechange:"1.870",changepercent:"10.011",buy:"20.55",sell:"0.00",settlement:"18.68",open:"20.55",high:"20.55",low:"20.55",volume:339967,amount:6986322,ticktime:"15:05:54",per:622.727,pb:5.815,mktcap:1573042.66662,nmc:1518184.56492,turnoverratio:0.04602},{symbol:"sh603766",code:"603766",name:"隆鑫通用",trade:"22.09",pricechange:"2.010",changepercent:"10.010",buy:"22.09",sell:"0.00",settlement:"20.08",open:"21.10",high:"22.09",low:"20.75",volume:37543840,amount:807108089,ticktime:"15:03:06",per:29.066,pb:4.342,mktcap:1778053.72269,nmc:878160.13869,turnoverratio:9.4441},{symbol:"sh600685",code:"600685",name:"广船国际",trade:"48.69",pricechange:"4.430",changepercent:"10.009",buy:"48.69",sell:"0.00",settlement:"44.26",open:"44.75",high:"48.69",low:"44.67",volume:33506901,amount:1596688416,ticktime:"15:03:06",per:331.224,pb:8.914,mktcap:6882362.554482,nmc:2134878.557526,turnoverratio:7.64189},{symbol:"sh600477",code:"600477",name:"杭萧钢构",trade:"14.51",pricechange:"1.320",changepercent:"10.008",buy:"14.51",sell:"0.00",settlement:"13.19",open:"13.35",high:"14.51",low:"13.35",volume:36354036,amount:517385167,ticktime:"15:03:06",per:151.146,pb:6.926,mktcap:803067.872867,nmc:672477.872867,turnoverratio:7.84408},{symbol:"sz002747",code:"002747",name:"埃斯顿",trade:"59.92",pricechange:"5.450",changepercent:"10.006",buy:"59.92",sell:"0.00",settlement:"54.47",open:"59.30",high:"59.92",low:"58.01",volume:5909141,amount:351222193,ticktime:"15:05:54",per:0,pb:0,mktcap:719040,nmc:179760,turnoverratio:19.69714},{symbol:"sh600196",code:"600196",name:"复星医药",trade:"27.27",pricechange:"2.480",changepercent:"10.004",buy:"27.27",sell:"0.00",settlement:"24.79",open:"27.27",high:"27.27",low:"27.27",volume:4999306,amount:136331075,ticktime:"15:03:06",per:29.641,pb:3.78,mktcap:6303134.252628,nmc:5196611.243268,turnoverratio:0.26235},{symbol:"sz300379",code:"300379",name:"东方通",trade:"79.610",pricechange:"7.240",changepercent:"10.004",buy:"79.610",sell:"0.000",settlement:"72.370",open:"79.610",high:"79.610",low:"78.770",volume:4448668,amount:354121784,ticktime:"15:05:54",per:70.941,pb:5.87,mktcap:917268.8083,nmc:231748.92933,turnoverratio:15.28199},{symbol:"sh600150",code:"600150",name:"中国船舶",trade:"54.22",pricechange:"4.930",changepercent:"10.002",buy:"54.22",sell:"0.00",settlement:"49.29",open:"49.88",high:"54.22",low:"49.30",volume:104978959,amount:5535263959,ticktime:"15:03:06",per:1807.333,pb:4.294,mktcap:7472153.616356,nmc:7472153.616356,turnoverratio:7.61756},{symbol:"sh600826",code:"600826",name:"兰生股份",trade:"34.10",pricechange:"3.100",changepercent:"10.000",buy:"34.10",sell:"0.00",settlement:"31.00",open:"31.32",high:"34.10",low:"30.75",volume:12457732,amount:403954457,ticktime:"15:03:06",per:27.171,pb:3.563,mktcap:1434390.20208,nmc:1434390.20208,turnoverratio:2.9616},{symbol:"sh601186",code:"601186",name:"中国铁建",trade:"23.76",pricechange:"2.160",changepercent:"10.000",buy:"23.76",sell:"0.00",settlement:"21.60",open:"21.65",high:"23.76",low:"21.65",volume:549087823,amount:12710359432,ticktime:"15:03:06",per:25.826,pb:3.224,mktcap:29313998.604,nmc:24380719.308,turnoverratio:5.35108},{symbol:"sh601872",code:"601872",name:"招商轮船",trade:"8.80",pricechange:"0.800",changepercent:"10.000",buy:"8.80",sell:"0.00",settlement:"8.00",open:"8.20",high:"8.80",low:"8.18",volume:300276620,amount:2616714351,ticktime:"15:03:06",per:220,pb:4.117,mktcap:4154411.19192,nmc:4154411.19192,turnoverratio:6.36055},{symbol:"sh603869",code:"603869",name:"北部湾旅",trade:"30.25",pricechange:"2.750",changepercent:"10.000",buy:"30.25",sell:"0.00",settlement:"27.50",open:"29.01",high:"30.25",low:"28.87",volume:5301108,amount:157240770,ticktime:"15:03:06",per:94.531,pb:10.54,mktcap:654126,nmc:163531.5,turnoverratio:9.80597},{symbol:"sz000591",code:"000591",name:"桐 君 阁",trade:"15.73",pricechange:"1.430",changepercent:"10.000",buy:"15.73",sell:"0.00",settlement:"14.30",open:"15.73",high:"15.73",low:"15.73",volume:42705,amount:671750,ticktime:"15:05:54",per:1115.603,pb:10.851,mktcap:431994.536259,nmc:431980.261284,turnoverratio:0.01555},{symbol:"sz000758",code:"000758",name:"中色股份",trade:"24.64",pricechange:"2.240",changepercent:"10.000",buy:"24.64",sell:"0.00",settlement:"22.40",open:"22.68",high:"24.64",low:"22.68",volume:29865953,amount:718762818,ticktime:"15:05:54",per:286.512,pb:5.563,mktcap:2426274.218368,nmc:2221447.740512,turnoverratio:3.31269},{symbol:"sz002221",code:"002221",name:"东华能源",trade:"38.50",pricechange:"3.500",changepercent:"10.000",buy:"38.50",sell:"0.00",settlement:"35.00",open:"35.25",high:"38.50",low:"35.25",volume:9344141,amount:354050610,ticktime:"15:05:54",per:175,pb:9.253,mktcap:2665532.8084,nmc:1721675.0705,turnoverratio:2.08953},{symbol:"sz002364",code:"002364",name:"中恒电气",trade:"49.06",pricechange:"4.460",changepercent:"10.000",buy:"49.06",sell:"0.00",settlement:"44.60",open:"49.06",high:"49.06",low:"49.06",volume:377028,amount:18496994,ticktime:"15:05:54",per:100.122,pb:13.323,mktcap:1283513.55814,nmc:1028801.9368,turnoverratio:0.17979},{symbol:"sz002544",code:"002544",name:"杰赛科技",trade:"31.79",pricechange:"2.890",changepercent:"10.000",buy:"31.79",sell:"0.00",settlement:"28.90",open:"29.39",high:"31.79",low:"28.78",volume:14080773,amount:423904771,ticktime:"15:05:54",per:113.536,pb:15.076,mktcap:1639601.04,nmc:1609707.720412,turnoverratio:2.7808},{symbol:"sz300032",code:"300032",name:"金龙机电",trade:"59.070",pricechange:"5.370",changepercent:"10.000",buy:"59.070",sell:"0.000",settlement:"53.700",open:"54.310",high:"59.070",low:"53.020",volume:8222654,amount:463307815,ticktime:"15:05:54",per:147.675,pb:10.793,mktcap:1996388.465115,nmc:1587701.919375,turnoverratio:3.05922},{symbol:"sz300187",code:"300187",name:"永清环保",trade:"47.300",pricechange:"4.300",changepercent:"10.000",buy:"47.300",sell:"0.000",settlement:"43.000",open:"43.260",high:"47.300",low:"43.260",volume:6445173,amount:301749473,ticktime:"15:05:54",per:175.185,pb:10.566,mktcap:947608.2,nmc:933666.525,turnoverratio:3.26516},{symbol:"sz300208",code:"300208",name:"恒顺众昇",trade:"45.880",pricechange:"4.170",changepercent:"9.998",buy:"45.880",sell:"0.000",settlement:"41.710",open:"41.820",high:"45.880",low:"41.300",volume:13578317,amount:599204400,ticktime:"15:05:54",per:120.737,pb:17.201,mktcap:1385438.36,nmc:1275544.170712,turnoverratio:4.88398},{symbol:"sh601021",code:"601021",name:"春秋航空",trade:"98.59",pricechange:"8.960",changepercent:"9.997",buy:"98.59",sell:"0.00",settlement:"89.63",open:"91.00",high:"98.59",low:"86.60",volume:6998133,amount:637562043,ticktime:"15:03:06",per:33.42,pb:8.324,mktcap:3943600,nmc:985900,turnoverratio:6.99813},{symbol:"sh600037",code:"600037",name:"歌华有线",trade:"27.62",pricechange:"2.510",changepercent:"9.996",buy:"27.62",sell:"0.00",settlement:"25.11",open:"25.20",high:"27.62",low:"25.20",volume:62953619,amount:1699096257,ticktime:"15:03:06",per:51.539,pb:4.672,mktcap:2943977.10438,nmc:2943977.10438,turnoverratio:5.90622},{symbol:"sh601808",code:"601808",name:"中海油服",trade:"27.18",pricechange:"2.470",changepercent:"9.996",buy:"27.18",sell:"0.00",settlement:"24.71",open:"25.00",high:"27.18",low:"24.80",volume:115336142,amount:3049804113,ticktime:"15:03:06",per:17.312,pb:2.743,mktcap:12969187.056,nmc:8046552.024,turnoverratio:3.89588},{symbol:"sh601766",code:"601766",name:"中国南车",trade:"35.88",pricechange:"3.260",changepercent:"9.994",buy:"35.88",sell:"0.00",settlement:"32.62",open:"35.88",high:"35.88",low:"35.88",volume:38949900,amount:1397522412,ticktime:"15:03:06",per:92,pb:12.225,mktcap:49525164,nmc:42263052,turnoverratio:0.33067},{symbol:"sz300431",code:"300431",name:"暴风科技",trade:"51.950",pricechange:"4.720",changepercent:"9.994",buy:"51.950",sell:"0.000",settlement:"47.230",open:"51.950",high:"51.950",low:"51.950",volume:85505,amount:4441985,ticktime:"15:05:54",per:110.532,pb:16.285,mktcap:623400,nmc:155850,turnoverratio:0.28502},{symbol:"sh600583",code:"600583",name:"海油工程",trade:"15.30",pricechange:"1.390",changepercent:"9.993",buy:"15.30",sell:"0.00",settlement:"13.91",open:"14.16",high:"15.30",low:"13.98",volume:276441510,amount:4083809384,ticktime:"15:03:06",per:15.773,pb:3.291,mktcap:6764672.844,nmc:6194991.726,turnoverratio:6.82738},{symbol:"sz002517",code:"002517",name:"泰亚股份",trade:"15.85",pricechange:"1.440",changepercent:"9.993",buy:"15.85",sell:"0.00",settlement:"14.41",open:"15.85",high:"15.85",low:"15.85",volume:22682,amount:359510,ticktime:"15:05:54",per:-52.833,pb:4.67,mktcap:280228,nmc:280228,turnoverratio:0.01283},{symbol:"sz002625",code:"002625",name:"龙生股份",trade:"32.58",pricechange:"2.960",changepercent:"9.993",buy:"32.58",sell:"0.00",settlement:"29.62",open:"32.58",high:"32.58",low:"32.58",volume:372003,amount:12119858,ticktime:"15:05:54",per:148.091,pb:12.164,mktcap:979857.164052,nmc:612494.887374,turnoverratio:0.19788},{symbol:"sh600875",code:"600875",name:"东方电气",trade:"27.41",pricechange:"2.490",changepercent:"9.992",buy:"27.41",sell:"0.00",settlement:"24.92",open:"27.26",high:"27.41",low:"25.60",volume:310525566,amount:8468348379,ticktime:"15:03:06",per:42.828,pb:2.81,mktcap:6405443.908688,nmc:5473503.908688,turnoverratio:15.55038},{symbol:"sh601727",code:"601727",name:"上海电气",trade:"14.53",pricechange:"1.320",changepercent:"9.992",buy:"14.53",sell:"0.00",settlement:"13.21",open:"14.53",high:"14.53",low:"14.53",volume:23604733,amount:342976770,ticktime:"15:03:06",per:72.942,pb:5.442,mktcap:18632729.53698,nmc:14313088.40098,turnoverratio:0.23962},{symbol:"sz002522",code:"002522",name:"浙江众成",trade:"42.49",pricechange:"3.860",changepercent:"9.992",buy:"42.49",sell:"0.00",settlement:"38.63",open:"39.52",high:"42.49",low:"39.50",volume:11242494,amount:472840999,ticktime:"15:05:54",per:303.5,pb:13.831,mktcap:1876533.0339,nmc:949081.7091,turnoverratio:5.03322},{symbol:"sh600058",code:"600058",name:"五矿发展",trade:"23.56",pricechange:"2.140",changepercent:"9.991",buy:"23.56",sell:"0.00",settlement:"21.42",open:"21.47",high:"23.56",low:"21.36",volume:56020102,amount:1283403846,ticktime:"15:03:06",per:120.204,pb:2.923,mktcap:2525421.635116,nmc:2525421.635116,turnoverratio:5.22619},{symbol:"sh603688",code:"603688",name:"石英股份",trade:"24.11",pricechange:"2.190",changepercent:"9.991",buy:"24.11",sell:"0.00",settlement:"21.92",open:"22.22",high:"24.11",low:"22.16",volume:9284353,amount:219783191,ticktime:"15:03:06",per:65.162,pb:4.587,mktcap:539581.8,nmc:134895.45,turnoverratio:16.59402},{symbol:"sh603788",code:"603788",name:"宁波高发",trade:"32.04",pricechange:"2.910",changepercent:"9.990",buy:"32.04",sell:"0.00",settlement:"29.13",open:"29.56",high:"32.04",low:"29.23",volume:9950670,amount:311945000,ticktime:"15:03:06",per:34.452,pb:9.722,mktcap:438307.2,nmc:109576.8,turnoverratio:29.09553},{symbol:"sz000070",code:"000070",name:"特发信息",trade:"17.73",pricechange:"1.610",changepercent:"9.988",buy:"17.73",sell:"0.00",settlement:"16.12",open:"17.73",high:"17.73",low:"17.73",volume:264270,amount:4685507,ticktime:"15:05:54",per:77.661,pb:4.539,mktcap:480483,nmc:458437.408074,turnoverratio:0.10221},{symbol:"sz300066",code:"300066",name:"三川股份",trade:"23.900",pricechange:"2.170",changepercent:"9.986",buy:"23.900",sell:"0.000",settlement:"21.730",open:"21.920",high:"23.900",low:"21.920",volume:7686940,amount:177465293,ticktime:"15:05:54",per:47.8,pb:5.301,mktcap:596396.9194,nmc:556306.76304,turnoverratio:3.30246},{symbol:"sz000881",code:"000881",name:"大连国际",trade:"13.22",pricechange:"1.200",changepercent:"9.983",buy:"13.22",sell:"0.00",settlement:"12.02",open:"12.19",high:"13.22",low:"12.19",volume:44029676,amount:569267815,ticktime:"15:05:54",per:37.771,pb:2.491,mktcap:408390.1248,nmc:407128.517726,turnoverratio:14.29702},{symbol:"sh600745",code:"600745",name:"中茵股份",trade:"16.42",pricechange:"1.490",changepercent:"9.980",buy:"16.42",sell:"0.00",settlement:"14.93",open:"16.42",high:"16.42",low:"16.42",volume:43104,amount:707768,ticktime:"15:03:06",per:102.625,pb:3.058,mktcap:793612.0147,nmc:537549.579232,turnoverratio:0.01317},{symbol:"sh600665",code:"600665",name:"天地源",trade:"9.92",pricechange:"0.900",changepercent:"9.978",buy:"9.92",sell:"0.00",settlement:"9.02",open:"8.93",high:"9.92",low:"8.90",volume:97756770,amount:927497466,ticktime:"15:03:06",per:29.091,pb:3.318,mktcap:857209.540832,nmc:857209.540832,turnoverratio:11.31284},{symbol:"sz000971",code:"000971",name:"蓝鼎控股",trade:"20.06",pricechange:"1.820",changepercent:"9.978",buy:"20.06",sell:"0.00",settlement:"18.24",open:"20.06",high:"20.06",low:"20.06",volume:21369041,amount:428662962,ticktime:"15:05:54",per:1003,pb:204.277,mktcap:487658.6,nmc:487007.19162,turnoverratio:8.80198},{symbol:"sh601106",code:"601106",name:"中国一重",trade:"7.94",pricechange:"0.720",changepercent:"9.972",buy:"7.94",sell:"0.00",settlement:"7.22",open:"7.94",high:"7.94",low:"7.94",volume:41305807,amount:327968108,ticktime:"15:03:06",per:3053.846,pb:3.231,mktcap:5191172,nmc:5191172,turnoverratio:0.63178},{symbol:"sz300243",code:"300243",name:"瑞丰高材",trade:"14.010",pricechange:"1.270",changepercent:"9.969",buy:"14.010",sell:"0.000",settlement:"12.740",open:"14.010",high:"14.010",low:"13.800",volume:8802392,amount:123205214,ticktime:"15:05:54",per:82.412,pb:6.847,mktcap:289835.450352,nmc:186988.847328,turnoverratio:6.59513},{symbol:"sh600428",code:"600428",name:"中远航运",trade:"10.04",pricechange:"0.910",changepercent:"9.967",buy:"10.04",sell:"0.00",settlement:"9.13",open:"9.29",high:"10.04",low:"9.29",volume:141568370,amount:1408969589,ticktime:"15:03:06",per:85.812,pb:2.6,mktcap:1697208.178572,nmc:1697208.178572,turnoverratio:8.37461},{symbol:"sh600018",code:"600018",name:"上港集团",trade:"9.82",pricechange:"0.890",changepercent:"9.966",buy:"9.82",sell:"0.00",settlement:"8.93",open:"8.94",high:"9.82",low:"8.93",volume:409648521,amount:3925189870,ticktime:"15:03:06",per:33.02,pb:4.095,mktcap:22345586.4163,nmc:22345586.4163,turnoverratio:1.80024},{symbol:"sh600026",code:"600026",name:"中海发展",trade:"11.59",pricechange:"1.050",changepercent:"9.962",buy:"11.59",sell:"0.00",settlement:"10.54",open:"10.78",high:"11.59",low:"10.65",volume:329601888,amount:3784034513,ticktime:"15:03:06",per:126.944,pb:1.848,mktcap:4673126.085899,nmc:3171062.085899,turnoverratio:12.04671},{symbol:"sh601618",code:"601618",name:"中国中冶",trade:"6.74",pricechange:"0.610",changepercent:"9.951",buy:"6.74",sell:"0.00",settlement:"6.13",open:"6.18",high:"6.74",low:"6.11",volume:661322921,amount:4361158596,ticktime:"15:03:06",per:32.095,pb:2.721,mktcap:12880140,nmc:10945086,turnoverratio:4.07244},{symbol:"sh601333",code:"601333",name:"广深铁路",trade:"6.41",pricechange:"0.580",changepercent:"9.949",buy:"6.41",sell:"0.00",settlement:"5.83",open:"5.88",high:"6.41",low:"5.88",volume:489396734,amount:3037939414,ticktime:"15:03:06",per:71.222,pb:1.698,mktcap:4540547.217,nmc:3623083.917,turnoverratio:8.65846},{symbol:"sh601866",code:"601866",name:"中海集运",trade:"7.85",pricechange:"0.710",changepercent:"9.944",buy:"7.85",sell:"0.00",settlement:"7.14",open:"7.29",high:"7.85",low:"7.28",volume:373963291,amount:2915013721,ticktime:"15:03:06",per:86.454,pb:3.699,mktcap:9171253.125,nmc:6226718.125,turnoverratio:4.71454},{symbol:"sh600321",code:"600321",name:"国栋建设",trade:"6.53",pricechange:"0.590",changepercent:"9.933",buy:"6.53",sell:"0.00",settlement:"5.94",open:"5.95",high:"6.53",low:"5.95",volume:134243295,amount:848721771,ticktime:"15:03:06",per:103.651,pb:3.608,mktcap:986389.15,nmc:771114.64,turnoverratio:11.36807},{symbol:"sh600320",code:"600320",name:"振华重工",trade:"9.21",pricechange:"0.830",changepercent:"9.905",buy:"9.21",sell:"9.22",settlement:"8.38",open:"8.45",high:"9.22",low:"8.45",volume:288768803,amount:2605079566,ticktime:"15:03:06",per:204.667,pb:2.736,mktcap:4043461.311864,nmc:2549633.204664,turnoverratio:10.43115},{symbol:"sz300064",code:"300064",name:"豫金刚石",trade:"15.400",pricechange:"1.380",changepercent:"9.843",buy:"15.390",sell:"15.400",settlement:"14.020",open:"14.200",high:"15.420",low:"14.190",volume:31005806,amount:461268844,ticktime:"15:05:54",per:99.355,pb:6.468,mktcap:936320,nmc:932855.02464,turnoverratio:5.11858},{symbol:"sh601880",code:"601880",name:"大连港",trade:"7.94",pricechange:"0.710",changepercent:"9.820",buy:"7.94",sell:"7.95",settlement:"7.23",open:"7.23",high:"7.95",low:"7.18",volume:260090063,amount:2007682855,ticktime:"15:03:06",per:67.517,pb:2.561,mktcap:3514244,nmc:2670539.6,turnoverratio:7.73295},{symbol:"sz002116",code:"002116",name:"中国海诚",trade:"25.21",pricechange:"2.220",changepercent:"9.656",buy:"25.20",sell:"25.21",settlement:"22.99",open:"23.02",high:"25.29",low:"22.81",volume:13306925,amount:321083595,ticktime:"15:05:54",per:32.321,pb:9.392,mktcap:782387.096236,nmc:777451.747141,turnoverratio:4.31496},{symbol:"sz000905",code:"000905",name:"厦门港务",trade:"23.84",pricechange:"2.050",changepercent:"9.408",buy:"23.83",sell:"23.84",settlement:"21.79",open:"22.00",high:"23.97",low:"21.70",volume:64971445,amount:1481214774,ticktime:"15:05:54",per:44.148,pb:4.983,mktcap:1265904,nmc:1265904,turnoverratio:12.23568},{symbol:"sh601007",code:"601007",name:"金陵饭店",trade:"22.31",pricechange:"1.910",changepercent:"9.363",buy:"22.33",sell:"22.35",settlement:"20.40",open:"20.41",high:"22.44",low:"20.41",volume:11398250,amount:250551380,ticktime:"15:03:06",per:167.997,pb:4.913,mktcap:669300,nmc:669300,turnoverratio:3.79942}]';
                $Content=@file_get_contents(ROOT_PATH.'/Stock/data/'.$file);
                copy(ROOT_PATH.'/Stock/data/'.$file,ROOT_PATH.'/Stock/data/converted/'.$file);
                unlink(ROOT_PATH.'/Stock/data/'.$file);
                $Encoding=mb_detect_encoding($Content);
                $Content=substr($Content,17,strlen($Content)-19);
                
                //所有字符串必须加上双引号
                $ExplodeList1=explode('{',$Content);
                $ExplodeList2=array();
                foreach($ExplodeList1 as $v){
                    $ExplodeList2=array_merge_recursive($ExplodeList2,explode(':',$v));
                }
                $ExplodeList3=array();
                foreach($ExplodeList2 as $v){
                    $ExplodeList3=array_merge_recursive($ExplodeList3,explode(',',$v));
                }
                
                $Content=stripslashes($Content);
                $ContentUTF8=mb_convert_encoding($Content,'utf-8','gbk');
                $ContentGBK=mb_convert_encoding($Content,'gbk','utf-8');
                //$Content=substr($Content,1,strlen($Content)-2);
                
                //$Content=str_replace("'", '"',$Content);//将单引替换成双引
                //preg_replace('/,\s*([\]}])/m', '$1', $Content);//去掉多余的逗号
                $ContentNew=preg_replace('/(w+)/i', '', $Content);
                //$p='/^[A-Z].*[A-Z]$/'; $a=preg_replace($p,'','jb51.net');
                $ContentNew=ereg_replace('[a-z:]+','**@',$Content);
                
                /*$FieldList=array('id',
'amount',
'buy',
'changepercent',
'code',
'high',
'low',
'mktcap',
'name',
'nmc',
'open',
'pb',
'per',
'pricechange',
'sell',
'settlement',
'symbol',
'ticktime',
'trade',
'turnoverratio',
'volume');
                
                foreach($FieldList as $v){
                    $Content=str_replace($v,'"'.$v.'"',$Content);
                    $ContentUTF8=str_replace($v,'"'.$v.'"',$ContentUTF8);
                    $ContentGBK=str_replace($v,'"'.$v.'"',$ContentGBK);
                }
                $Content=str_replace('"change"per"cent"','"changepercent"',$Content);
                $ContentUTF8=str_replace('"change"per"cent"','"changepercent"',$ContentUTF8);
                $ContentGBK=str_replace('"change"per"cent"','"changepercent"',$ContentGBK);
                $ContentNew1=str_replace('{','{"',$Content);
                $ContentNew2=ereg_replace('[a-z:]+',"\\1\"",$ContentNew1);
                $ContentNew3=str_replace(',',',"',$ContentNew2);*/
                
                $new_array=array();
                $new_array=json_decode($Content);
                
                switch (json_last_error()) {
                    case JSON_ERROR_NONE:
                        echo $ErrorInfo=' - No errors';
                        break;
                    case JSON_ERROR_DEPTH:
                        echo $ErrorInfo=' - Maximum stack depth exceeded';
                        break;
                    case JSON_ERROR_STATE_MISMATCH:
                        echo $ErrorInfo=' - Underflow or the modes mismatch';
                        break;
                    case JSON_ERROR_CTRL_CHAR:
                        echo $ErrorInfo=' - Unexpected control character found';
                        break;
                    case JSON_ERROR_SYNTAX:
                        echo $ErrorInfo=' - Syntax error, malformed JSON';
                        break;
                    case JSON_ERROR_UTF8:
                        echo $ErrorInfo=' - Malformed UTF-8 characters, possibly incorrectly encoded';
                        break;
                    default:
                        echo $ErrorInfo=' - Unknown error';
                        break;
                }
                
                echo $ErrorInfo=json_last_error();
                $ContentGBKJson=json_decode($ContentGBK,true);  
                $ContentUTF8Json=json_decode($ContentUTF8,true);  
                $ContentJson=json_decode($ContentUTF8,true);
                
                $SymbolRefExp=explode('.',$file);
                $SymbolRef=$SymbolRefExp[0];                
                
                $StockPriceList=M('stock_price')->where(array('symbol'=>$ContentJson['symbol']))->count();
                if($StockPriceList<count($ContentJson['data'])){
                    foreach($ContentJson['data'] as $v){
                        $StockInfo=M('stock_price')->where(array('symbol'=>$ContentJson['symbol'],'date'=>$v[0]))->find();
                        if(!$StockInfo){
                            M('stock_price')->add(array('count'=>$ContentJson['count'],'symbol'=>mb_convert_encoding($ContentJson['symbol'],'gbk','utf-8'),'name'=>$ContentJson['name'],'yestclose'=>$ContentJson['yestclose'],'symbol_ref'=>$SymbolRef,'date'=>$v[0],'price_min'=>$v[1],'price_max'=>$v[2],'amount'=>$v[3]));                       
                        }
                    }
                }  
                
            }
        } 
        return ($ConvertedFileCount>0)?2:1;
    }
    private function ConvertStockList($Min=null,$Max=null){        
        if(is_numeric($Min)&&is_numeric($Max)&&($Min<=$Max)){            
            for($i=$Min;$i<=$Max;$i++){
                if(file_exists(ROOT_PATH.'/Stock/'.$i.'.html')){ 
                    echo '<script>parent.PostReturnCallback(\''.'正在添加！'.$i.'\');</script>';  
                    ob_flush();
                    flush();  
                    ob_end_flush();                     
                    //$Content='[{symbol:"sh601588",code:"601588",name:"北辰实业",trade:"6.23",pricechange:"0.570",changepercent:"10.071",buy:"6.23",sell:"0.00",settlement:"5.66",open:"6.23",high:"6.23",low:"6.23",volume:3457900,amount:21542717,ticktime:"15:03:06",per:38.938,pb:1.924,mktcap:2097653.46,nmc:1657180,turnoverratio:0.13},{symbol:"sz000616",code:"000616",name:"海航投资",trade:"5.25",pricechange:"0.480",changepercent:"10.063",buy:"5.25",sell:"0.00",settlement:"4.77",open:"5.25",high:"5.25",low:"5.25",volume:473151,amount:2484043,ticktime:"15:05:54",per:35,pb:1.782,mktcap:750873.073125,nmc:750868.869975,turnoverratio:0.03308},{symbol:"sz300116",code:"300116",name:"坚瑞消防",trade:"10.180",pricechange:"0.930",changepercent:"10.054",buy:"10.180",sell:"0.000",settlement:"9.250",open:"10.180",high:"10.180",low:"10.180",volume:13877137,amount:141269255,ticktime:"15:05:54",per:285.154,pb:3.66,mktcap:339494.59132,nmc:165659.4963,turnoverratio:8.52769},{symbol:"sh601918",code:"601918",name:"国投新集",trade:"10.62",pricechange:"0.970",changepercent:"10.052",buy:"10.62",sell:"0.00",settlement:"9.65",open:"9.99",high:"10.62",low:"9.69",volume:173376399,amount:1784527355,ticktime:"15:03:06",per:1770,pb:3.588,mktcap:2751155.3916,nmc:2751155.3916,turnoverratio:6.69267},{symbol:"sz000507",code:"000507",name:"珠海港",trade:"12.71",pricechange:"1.160",changepercent:"10.043",buy:"12.71",sell:"0.00",settlement:"11.55",open:"12.19",high:"12.71",low:"11.75",volume:147578090,amount:1826664491,ticktime:"15:05:54",per:585.714,pb:4.098,mktcap:1003506.508049,nmc:981394.741838,turnoverratio:19.11277},{symbol:"sh600157",code:"600157",name:"永泰能源",trade:"8.44",pricechange:"0.770",changepercent:"10.039",buy:"8.44",sell:"0.00",settlement:"7.67",open:"8.00",high:"8.44",low:"7.98",volume:425236354,amount:3534271858,ticktime:"15:03:06",per:31.306,pb:2.979,mktcap:7267904.445204,nmc:2983640.48664,turnoverratio:12.02891},{symbol:"sh600731",code:"600731",name:"湖南海利",trade:"11.95",pricechange:"1.090",changepercent:"10.037",buy:"11.95",sell:"0.00",settlement:"10.86",open:"10.75",high:"11.95",low:"10.70",volume:16395656,amount:187439626,ticktime:"15:03:06",per:385.484,pb:5.389,mktcap:391140.34711,nmc:305505.474815,turnoverratio:6.41324},{symbol:"sz002509",code:"002509",name:"天广消防",trade:"16.34",pricechange:"1.490",changepercent:"10.034",buy:"16.34",sell:"0.00",settlement:"14.85",open:"16.34",high:"16.34",low:"16.34",volume:66624,amount:1088636,ticktime:"15:05:54",per:58.357,pb:4.974,mktcap:745824.902826,nmc:377489.026424,turnoverratio:0.02884},{symbol:"sh601069",code:"601069",name:"西部黄金",trade:"20.96",pricechange:"1.910",changepercent:"10.026",buy:"20.96",sell:"0.00",settlement:"19.05",open:"18.75",high:"20.96",low:"18.55",volume:32769673,amount:653195163,ticktime:"15:03:06",per:136.281,pb:9.404,mktcap:1333056,nmc:264096,turnoverratio:26.00768},{symbol:"sz000576",code:"000576",name:"广东甘化",trade:"17.45",pricechange:"1.590",changepercent:"10.025",buy:"17.45",sell:"0.00",settlement:"15.86",open:"15.88",high:"17.45",low:"15.74",volume:42164822,amount:704931237,ticktime:"15:05:54",per:872.5,pb:7.574,mktcap:772793.01038,nmc:446991.02991,turnoverratio:16.46065},{symbol:"sz002478",code:"002478",name:"常宝股份",trade:"17.45",pricechange:"1.590",changepercent:"10.025",buy:"17.45",sell:"0.00",settlement:"15.86",open:"16.70",high:"17.45",low:"16.70",volume:29393534,amount:510159762,ticktime:"15:05:54",per:28.607,pb:2.445,mktcap:698174.5,nmc:488815.079975,turnoverratio:10.49307},{symbol:"sh601390",code:"601390",name:"中国中铁",trade:"18.00",pricechange:"1.640",changepercent:"10.024",buy:"18.00",sell:"0.00",settlement:"16.36",open:"16.29",high:"18.00",low:"16.02",volume:1094350230,amount:19294382071,ticktime:"15:03:06",per:37.344,pb:3.884,mktcap:38339820,nmc:30766518,turnoverratio:6.40251},{symbol:"sz000061",code:"000061",name:"农 产 品",trade:"18.44",pricechange:"1.680",changepercent:"10.024",buy:"18.44",sell:"0.00",settlement:"16.76",open:"16.80",high:"18.44",low:"16.60",volume:63498183,amount:1124313067,ticktime:"15:05:54",per:276.877,pb:6.46,mktcap:3129201.857564,nmc:2960905.95028,turnoverratio:3.95455},{symbol:"sz000517",code:"000517",name:"荣安地产",trade:"24.48",pricechange:"2.230",changepercent:"10.022",buy:"24.48",sell:"0.00",settlement:"22.25",open:"24.48",high:"24.48",low:"24.48",volume:1588016,amount:38874632,ticktime:"15:05:54",per:57.156,pb:7.449,mktcap:2598080.74776,nmc:2571992.59536,turnoverratio:0.15115},{symbol:"sz002298",code:"002298",name:"鑫龙电器",trade:"15.92",pricechange:"1.450",changepercent:"10.021",buy:"15.92",sell:"0.00",settlement:"14.47",open:"15.92",high:"15.92",low:"15.92",volume:415813,amount:6619743,ticktime:"15:05:54",per:439.779,pb:5.145,mktcap:658846.4936,nmc:555523.132072,turnoverratio:0.11916},{symbol:"sz000065",code:"000065",name:"北方国际",trade:"28.88",pricechange:"2.630",changepercent:"10.019",buy:"28.88",sell:"0.00",settlement:"26.25",open:"26.37",high:"28.88",low:"26.37",volume:21689205,amount:605374942,ticktime:"15:05:54",per:39.562,pb:7.624,mktcap:731824.707416,nmc:731824.707416,turnoverratio:8.55921},{symbol:"sh603003",code:"603003",name:"龙宇燃油",trade:"23.94",pricechange:"2.180",changepercent:"10.018",buy:"23.94",sell:"0.00",settlement:"21.76",open:"23.94",high:"23.94",low:"23.94",volume:85981,amount:2058385,ticktime:"15:03:06",per:654.098,pb:6.143,mktcap:483588,nmc:153482.5719,turnoverratio:0.13411},{symbol:"sz000968",code:"000968",name:"煤 气 化",trade:"12.08",pricechange:"1.100",changepercent:"10.018",buy:"12.08",sell:"0.00",settlement:"10.98",open:"11.98",high:"12.08",low:"11.50",volume:42373066,amount:507478561,ticktime:"15:05:54",per:-6.238,pb:3.387,mktcap:620606.376,nmc:620606.376,turnoverratio:8.24785},{symbol:"sh601989",code:"601989",name:"中国重工",trade:"13.07",pricechange:"1.190",changepercent:"10.017",buy:"13.07",sell:"0.00",settlement:"11.88",open:"12.08",high:"13.07",low:"12.00",volume:1313807423,amount:16795510845,ticktime:"15:03:06",per:65.35,pb:4.061,mktcap:23998696.241262,nmc:23470917.196008,turnoverratio:7.31606},{symbol:"sz000547",code:"000547",name:"闽福发Ａ",trade:"26.25",pricechange:"2.390",changepercent:"10.017",buy:"26.25",sell:"0.00",settlement:"23.86",open:"26.25",high:"26.25",low:"26.25",volume:1550444,amount:40699155,ticktime:"15:05:54",per:114.13,pb:10.93,mktcap:2490037.16325,nmc:2191471.65825,turnoverratio:0.18572},{symbol:"sz002208",code:"002208",name:"合肥城建",trade:"22.74",pricechange:"2.070",changepercent:"10.015",buy:"22.74",sell:"0.00",settlement:"20.67",open:"20.70",high:"22.74",low:"20.68",volume:19838479,amount:433041424,ticktime:"15:05:54",per:42.111,pb:4.885,mktcap:727907.4,nmc:720230.635236,turnoverratio:6.26365},{symbol:"sh600962",code:"600962",name:"国投中鲁",trade:"17.80",pricechange:"1.620",changepercent:"10.012",buy:"17.80",sell:"0.00",settlement:"16.18",open:"16.49",high:"17.80",low:"16.45",volume:29097871,amount:501710279,ticktime:"15:03:06",per:-49.832,pb:5.533,mktcap:466733.8,nmc:452155.6,turnoverratio:11.45495},{symbol:"sz300059",code:"300059",name:"东方财富",trade:"35.600",pricechange:"3.240",changepercent:"10.012",buy:"35.600",sell:"0.000",settlement:"32.360",open:"35.600",high:"35.600",low:"35.600",volume:895739,amount:31888308,ticktime:"15:05:54",per:259.854,pb:29.906,mktcap:6028646.4,nmc:4579068.25568,turnoverratio:0.06964},{symbol:"sh601299",code:"601299",name:"中国北车",trade:"38.46",pricechange:"3.500",changepercent:"10.011",buy:"38.46",sell:"0.00",settlement:"34.96",open:"38.46",high:"38.46",low:"38.46",volume:29419024,amount:1131455663,ticktime:"15:03:06",per:80.125,pb:9.663,mktcap:47151115.045338,nmc:38944918.690938,turnoverratio:0.29053},{symbol:"sh601919",code:"601919",name:"中国远洋",trade:"9.67",pricechange:"0.880",changepercent:"10.011",buy:"9.67",sell:"0.00",settlement:"8.79",open:"9.05",high:"9.67",low:"9.05",volume:107644992,amount:1027310477,ticktime:"15:03:06",per:241.75,pb:4.052,mktcap:9879137.303219,nmc:7383697.103219,turnoverratio:1.40976},{symbol:"sz000410",code:"000410",name:"沈阳机床",trade:"20.55",pricechange:"1.870",changepercent:"10.011",buy:"20.55",sell:"0.00",settlement:"18.68",open:"20.55",high:"20.55",low:"20.55",volume:339967,amount:6986322,ticktime:"15:05:54",per:622.727,pb:5.815,mktcap:1573042.66662,nmc:1518184.56492,turnoverratio:0.04602},{symbol:"sh603766",code:"603766",name:"隆鑫通用",trade:"22.09",pricechange:"2.010",changepercent:"10.010",buy:"22.09",sell:"0.00",settlement:"20.08",open:"21.10",high:"22.09",low:"20.75",volume:37543840,amount:807108089,ticktime:"15:03:06",per:29.066,pb:4.342,mktcap:1778053.72269,nmc:878160.13869,turnoverratio:9.4441},{symbol:"sh600685",code:"600685",name:"广船国际",trade:"48.69",pricechange:"4.430",changepercent:"10.009",buy:"48.69",sell:"0.00",settlement:"44.26",open:"44.75",high:"48.69",low:"44.67",volume:33506901,amount:1596688416,ticktime:"15:03:06",per:331.224,pb:8.914,mktcap:6882362.554482,nmc:2134878.557526,turnoverratio:7.64189},{symbol:"sh600477",code:"600477",name:"杭萧钢构",trade:"14.51",pricechange:"1.320",changepercent:"10.008",buy:"14.51",sell:"0.00",settlement:"13.19",open:"13.35",high:"14.51",low:"13.35",volume:36354036,amount:517385167,ticktime:"15:03:06",per:151.146,pb:6.926,mktcap:803067.872867,nmc:672477.872867,turnoverratio:7.84408},{symbol:"sz002747",code:"002747",name:"埃斯顿",trade:"59.92",pricechange:"5.450",changepercent:"10.006",buy:"59.92",sell:"0.00",settlement:"54.47",open:"59.30",high:"59.92",low:"58.01",volume:5909141,amount:351222193,ticktime:"15:05:54",per:0,pb:0,mktcap:719040,nmc:179760,turnoverratio:19.69714},{symbol:"sh600196",code:"600196",name:"复星医药",trade:"27.27",pricechange:"2.480",changepercent:"10.004",buy:"27.27",sell:"0.00",settlement:"24.79",open:"27.27",high:"27.27",low:"27.27",volume:4999306,amount:136331075,ticktime:"15:03:06",per:29.641,pb:3.78,mktcap:6303134.252628,nmc:5196611.243268,turnoverratio:0.26235},{symbol:"sz300379",code:"300379",name:"东方通",trade:"79.610",pricechange:"7.240",changepercent:"10.004",buy:"79.610",sell:"0.000",settlement:"72.370",open:"79.610",high:"79.610",low:"78.770",volume:4448668,amount:354121784,ticktime:"15:05:54",per:70.941,pb:5.87,mktcap:917268.8083,nmc:231748.92933,turnoverratio:15.28199},{symbol:"sh600150",code:"600150",name:"中国船舶",trade:"54.22",pricechange:"4.930",changepercent:"10.002",buy:"54.22",sell:"0.00",settlement:"49.29",open:"49.88",high:"54.22",low:"49.30",volume:104978959,amount:5535263959,ticktime:"15:03:06",per:1807.333,pb:4.294,mktcap:7472153.616356,nmc:7472153.616356,turnoverratio:7.61756},{symbol:"sh600826",code:"600826",name:"兰生股份",trade:"34.10",pricechange:"3.100",changepercent:"10.000",buy:"34.10",sell:"0.00",settlement:"31.00",open:"31.32",high:"34.10",low:"30.75",volume:12457732,amount:403954457,ticktime:"15:03:06",per:27.171,pb:3.563,mktcap:1434390.20208,nmc:1434390.20208,turnoverratio:2.9616},{symbol:"sh601186",code:"601186",name:"中国铁建",trade:"23.76",pricechange:"2.160",changepercent:"10.000",buy:"23.76",sell:"0.00",settlement:"21.60",open:"21.65",high:"23.76",low:"21.65",volume:549087823,amount:12710359432,ticktime:"15:03:06",per:25.826,pb:3.224,mktcap:29313998.604,nmc:24380719.308,turnoverratio:5.35108},{symbol:"sh601872",code:"601872",name:"招商轮船",trade:"8.80",pricechange:"0.800",changepercent:"10.000",buy:"8.80",sell:"0.00",settlement:"8.00",open:"8.20",high:"8.80",low:"8.18",volume:300276620,amount:2616714351,ticktime:"15:03:06",per:220,pb:4.117,mktcap:4154411.19192,nmc:4154411.19192,turnoverratio:6.36055},{symbol:"sh603869",code:"603869",name:"北部湾旅",trade:"30.25",pricechange:"2.750",changepercent:"10.000",buy:"30.25",sell:"0.00",settlement:"27.50",open:"29.01",high:"30.25",low:"28.87",volume:5301108,amount:157240770,ticktime:"15:03:06",per:94.531,pb:10.54,mktcap:654126,nmc:163531.5,turnoverratio:9.80597},{symbol:"sz000591",code:"000591",name:"桐 君 阁",trade:"15.73",pricechange:"1.430",changepercent:"10.000",buy:"15.73",sell:"0.00",settlement:"14.30",open:"15.73",high:"15.73",low:"15.73",volume:42705,amount:671750,ticktime:"15:05:54",per:1115.603,pb:10.851,mktcap:431994.536259,nmc:431980.261284,turnoverratio:0.01555},{symbol:"sz000758",code:"000758",name:"中色股份",trade:"24.64",pricechange:"2.240",changepercent:"10.000",buy:"24.64",sell:"0.00",settlement:"22.40",open:"22.68",high:"24.64",low:"22.68",volume:29865953,amount:718762818,ticktime:"15:05:54",per:286.512,pb:5.563,mktcap:2426274.218368,nmc:2221447.740512,turnoverratio:3.31269},{symbol:"sz002221",code:"002221",name:"东华能源",trade:"38.50",pricechange:"3.500",changepercent:"10.000",buy:"38.50",sell:"0.00",settlement:"35.00",open:"35.25",high:"38.50",low:"35.25",volume:9344141,amount:354050610,ticktime:"15:05:54",per:175,pb:9.253,mktcap:2665532.8084,nmc:1721675.0705,turnoverratio:2.08953},{symbol:"sz002364",code:"002364",name:"中恒电气",trade:"49.06",pricechange:"4.460",changepercent:"10.000",buy:"49.06",sell:"0.00",settlement:"44.60",open:"49.06",high:"49.06",low:"49.06",volume:377028,amount:18496994,ticktime:"15:05:54",per:100.122,pb:13.323,mktcap:1283513.55814,nmc:1028801.9368,turnoverratio:0.17979},{symbol:"sz002544",code:"002544",name:"杰赛科技",trade:"31.79",pricechange:"2.890",changepercent:"10.000",buy:"31.79",sell:"0.00",settlement:"28.90",open:"29.39",high:"31.79",low:"28.78",volume:14080773,amount:423904771,ticktime:"15:05:54",per:113.536,pb:15.076,mktcap:1639601.04,nmc:1609707.720412,turnoverratio:2.7808},{symbol:"sz300032",code:"300032",name:"金龙机电",trade:"59.070",pricechange:"5.370",changepercent:"10.000",buy:"59.070",sell:"0.000",settlement:"53.700",open:"54.310",high:"59.070",low:"53.020",volume:8222654,amount:463307815,ticktime:"15:05:54",per:147.675,pb:10.793,mktcap:1996388.465115,nmc:1587701.919375,turnoverratio:3.05922},{symbol:"sz300187",code:"300187",name:"永清环保",trade:"47.300",pricechange:"4.300",changepercent:"10.000",buy:"47.300",sell:"0.000",settlement:"43.000",open:"43.260",high:"47.300",low:"43.260",volume:6445173,amount:301749473,ticktime:"15:05:54",per:175.185,pb:10.566,mktcap:947608.2,nmc:933666.525,turnoverratio:3.26516},{symbol:"sz300208",code:"300208",name:"恒顺众昇",trade:"45.880",pricechange:"4.170",changepercent:"9.998",buy:"45.880",sell:"0.000",settlement:"41.710",open:"41.820",high:"45.880",low:"41.300",volume:13578317,amount:599204400,ticktime:"15:05:54",per:120.737,pb:17.201,mktcap:1385438.36,nmc:1275544.170712,turnoverratio:4.88398},{symbol:"sh601021",code:"601021",name:"春秋航空",trade:"98.59",pricechange:"8.960",changepercent:"9.997",buy:"98.59",sell:"0.00",settlement:"89.63",open:"91.00",high:"98.59",low:"86.60",volume:6998133,amount:637562043,ticktime:"15:03:06",per:33.42,pb:8.324,mktcap:3943600,nmc:985900,turnoverratio:6.99813},{symbol:"sh600037",code:"600037",name:"歌华有线",trade:"27.62",pricechange:"2.510",changepercent:"9.996",buy:"27.62",sell:"0.00",settlement:"25.11",open:"25.20",high:"27.62",low:"25.20",volume:62953619,amount:1699096257,ticktime:"15:03:06",per:51.539,pb:4.672,mktcap:2943977.10438,nmc:2943977.10438,turnoverratio:5.90622},{symbol:"sh601808",code:"601808",name:"中海油服",trade:"27.18",pricechange:"2.470",changepercent:"9.996",buy:"27.18",sell:"0.00",settlement:"24.71",open:"25.00",high:"27.18",low:"24.80",volume:115336142,amount:3049804113,ticktime:"15:03:06",per:17.312,pb:2.743,mktcap:12969187.056,nmc:8046552.024,turnoverratio:3.89588},{symbol:"sh601766",code:"601766",name:"中国南车",trade:"35.88",pricechange:"3.260",changepercent:"9.994",buy:"35.88",sell:"0.00",settlement:"32.62",open:"35.88",high:"35.88",low:"35.88",volume:38949900,amount:1397522412,ticktime:"15:03:06",per:92,pb:12.225,mktcap:49525164,nmc:42263052,turnoverratio:0.33067},{symbol:"sz300431",code:"300431",name:"暴风科技",trade:"51.950",pricechange:"4.720",changepercent:"9.994",buy:"51.950",sell:"0.000",settlement:"47.230",open:"51.950",high:"51.950",low:"51.950",volume:85505,amount:4441985,ticktime:"15:05:54",per:110.532,pb:16.285,mktcap:623400,nmc:155850,turnoverratio:0.28502},{symbol:"sh600583",code:"600583",name:"海油工程",trade:"15.30",pricechange:"1.390",changepercent:"9.993",buy:"15.30",sell:"0.00",settlement:"13.91",open:"14.16",high:"15.30",low:"13.98",volume:276441510,amount:4083809384,ticktime:"15:03:06",per:15.773,pb:3.291,mktcap:6764672.844,nmc:6194991.726,turnoverratio:6.82738},{symbol:"sz002517",code:"002517",name:"泰亚股份",trade:"15.85",pricechange:"1.440",changepercent:"9.993",buy:"15.85",sell:"0.00",settlement:"14.41",open:"15.85",high:"15.85",low:"15.85",volume:22682,amount:359510,ticktime:"15:05:54",per:-52.833,pb:4.67,mktcap:280228,nmc:280228,turnoverratio:0.01283},{symbol:"sz002625",code:"002625",name:"龙生股份",trade:"32.58",pricechange:"2.960",changepercent:"9.993",buy:"32.58",sell:"0.00",settlement:"29.62",open:"32.58",high:"32.58",low:"32.58",volume:372003,amount:12119858,ticktime:"15:05:54",per:148.091,pb:12.164,mktcap:979857.164052,nmc:612494.887374,turnoverratio:0.19788},{symbol:"sh600875",code:"600875",name:"东方电气",trade:"27.41",pricechange:"2.490",changepercent:"9.992",buy:"27.41",sell:"0.00",settlement:"24.92",open:"27.26",high:"27.41",low:"25.60",volume:310525566,amount:8468348379,ticktime:"15:03:06",per:42.828,pb:2.81,mktcap:6405443.908688,nmc:5473503.908688,turnoverratio:15.55038},{symbol:"sh601727",code:"601727",name:"上海电气",trade:"14.53",pricechange:"1.320",changepercent:"9.992",buy:"14.53",sell:"0.00",settlement:"13.21",open:"14.53",high:"14.53",low:"14.53",volume:23604733,amount:342976770,ticktime:"15:03:06",per:72.942,pb:5.442,mktcap:18632729.53698,nmc:14313088.40098,turnoverratio:0.23962},{symbol:"sz002522",code:"002522",name:"浙江众成",trade:"42.49",pricechange:"3.860",changepercent:"9.992",buy:"42.49",sell:"0.00",settlement:"38.63",open:"39.52",high:"42.49",low:"39.50",volume:11242494,amount:472840999,ticktime:"15:05:54",per:303.5,pb:13.831,mktcap:1876533.0339,nmc:949081.7091,turnoverratio:5.03322},{symbol:"sh600058",code:"600058",name:"五矿发展",trade:"23.56",pricechange:"2.140",changepercent:"9.991",buy:"23.56",sell:"0.00",settlement:"21.42",open:"21.47",high:"23.56",low:"21.36",volume:56020102,amount:1283403846,ticktime:"15:03:06",per:120.204,pb:2.923,mktcap:2525421.635116,nmc:2525421.635116,turnoverratio:5.22619},{symbol:"sh603688",code:"603688",name:"石英股份",trade:"24.11",pricechange:"2.190",changepercent:"9.991",buy:"24.11",sell:"0.00",settlement:"21.92",open:"22.22",high:"24.11",low:"22.16",volume:9284353,amount:219783191,ticktime:"15:03:06",per:65.162,pb:4.587,mktcap:539581.8,nmc:134895.45,turnoverratio:16.59402},{symbol:"sh603788",code:"603788",name:"宁波高发",trade:"32.04",pricechange:"2.910",changepercent:"9.990",buy:"32.04",sell:"0.00",settlement:"29.13",open:"29.56",high:"32.04",low:"29.23",volume:9950670,amount:311945000,ticktime:"15:03:06",per:34.452,pb:9.722,mktcap:438307.2,nmc:109576.8,turnoverratio:29.09553},{symbol:"sz000070",code:"000070",name:"特发信息",trade:"17.73",pricechange:"1.610",changepercent:"9.988",buy:"17.73",sell:"0.00",settlement:"16.12",open:"17.73",high:"17.73",low:"17.73",volume:264270,amount:4685507,ticktime:"15:05:54",per:77.661,pb:4.539,mktcap:480483,nmc:458437.408074,turnoverratio:0.10221},{symbol:"sz300066",code:"300066",name:"三川股份",trade:"23.900",pricechange:"2.170",changepercent:"9.986",buy:"23.900",sell:"0.000",settlement:"21.730",open:"21.920",high:"23.900",low:"21.920",volume:7686940,amount:177465293,ticktime:"15:05:54",per:47.8,pb:5.301,mktcap:596396.9194,nmc:556306.76304,turnoverratio:3.30246},{symbol:"sz000881",code:"000881",name:"大连国际",trade:"13.22",pricechange:"1.200",changepercent:"9.983",buy:"13.22",sell:"0.00",settlement:"12.02",open:"12.19",high:"13.22",low:"12.19",volume:44029676,amount:569267815,ticktime:"15:05:54",per:37.771,pb:2.491,mktcap:408390.1248,nmc:407128.517726,turnoverratio:14.29702},{symbol:"sh600745",code:"600745",name:"中茵股份",trade:"16.42",pricechange:"1.490",changepercent:"9.980",buy:"16.42",sell:"0.00",settlement:"14.93",open:"16.42",high:"16.42",low:"16.42",volume:43104,amount:707768,ticktime:"15:03:06",per:102.625,pb:3.058,mktcap:793612.0147,nmc:537549.579232,turnoverratio:0.01317},{symbol:"sh600665",code:"600665",name:"天地源",trade:"9.92",pricechange:"0.900",changepercent:"9.978",buy:"9.92",sell:"0.00",settlement:"9.02",open:"8.93",high:"9.92",low:"8.90",volume:97756770,amount:927497466,ticktime:"15:03:06",per:29.091,pb:3.318,mktcap:857209.540832,nmc:857209.540832,turnoverratio:11.31284},{symbol:"sz000971",code:"000971",name:"蓝鼎控股",trade:"20.06",pricechange:"1.820",changepercent:"9.978",buy:"20.06",sell:"0.00",settlement:"18.24",open:"20.06",high:"20.06",low:"20.06",volume:21369041,amount:428662962,ticktime:"15:05:54",per:1003,pb:204.277,mktcap:487658.6,nmc:487007.19162,turnoverratio:8.80198},{symbol:"sh601106",code:"601106",name:"中国一重",trade:"7.94",pricechange:"0.720",changepercent:"9.972",buy:"7.94",sell:"0.00",settlement:"7.22",open:"7.94",high:"7.94",low:"7.94",volume:41305807,amount:327968108,ticktime:"15:03:06",per:3053.846,pb:3.231,mktcap:5191172,nmc:5191172,turnoverratio:0.63178},{symbol:"sz300243",code:"300243",name:"瑞丰高材",trade:"14.010",pricechange:"1.270",changepercent:"9.969",buy:"14.010",sell:"0.000",settlement:"12.740",open:"14.010",high:"14.010",low:"13.800",volume:8802392,amount:123205214,ticktime:"15:05:54",per:82.412,pb:6.847,mktcap:289835.450352,nmc:186988.847328,turnoverratio:6.59513},{symbol:"sh600428",code:"600428",name:"中远航运",trade:"10.04",pricechange:"0.910",changepercent:"9.967",buy:"10.04",sell:"0.00",settlement:"9.13",open:"9.29",high:"10.04",low:"9.29",volume:141568370,amount:1408969589,ticktime:"15:03:06",per:85.812,pb:2.6,mktcap:1697208.178572,nmc:1697208.178572,turnoverratio:8.37461},{symbol:"sh600018",code:"600018",name:"上港集团",trade:"9.82",pricechange:"0.890",changepercent:"9.966",buy:"9.82",sell:"0.00",settlement:"8.93",open:"8.94",high:"9.82",low:"8.93",volume:409648521,amount:3925189870,ticktime:"15:03:06",per:33.02,pb:4.095,mktcap:22345586.4163,nmc:22345586.4163,turnoverratio:1.80024},{symbol:"sh600026",code:"600026",name:"中海发展",trade:"11.59",pricechange:"1.050",changepercent:"9.962",buy:"11.59",sell:"0.00",settlement:"10.54",open:"10.78",high:"11.59",low:"10.65",volume:329601888,amount:3784034513,ticktime:"15:03:06",per:126.944,pb:1.848,mktcap:4673126.085899,nmc:3171062.085899,turnoverratio:12.04671},{symbol:"sh601618",code:"601618",name:"中国中冶",trade:"6.74",pricechange:"0.610",changepercent:"9.951",buy:"6.74",sell:"0.00",settlement:"6.13",open:"6.18",high:"6.74",low:"6.11",volume:661322921,amount:4361158596,ticktime:"15:03:06",per:32.095,pb:2.721,mktcap:12880140,nmc:10945086,turnoverratio:4.07244},{symbol:"sh601333",code:"601333",name:"广深铁路",trade:"6.41",pricechange:"0.580",changepercent:"9.949",buy:"6.41",sell:"0.00",settlement:"5.83",open:"5.88",high:"6.41",low:"5.88",volume:489396734,amount:3037939414,ticktime:"15:03:06",per:71.222,pb:1.698,mktcap:4540547.217,nmc:3623083.917,turnoverratio:8.65846},{symbol:"sh601866",code:"601866",name:"中海集运",trade:"7.85",pricechange:"0.710",changepercent:"9.944",buy:"7.85",sell:"0.00",settlement:"7.14",open:"7.29",high:"7.85",low:"7.28",volume:373963291,amount:2915013721,ticktime:"15:03:06",per:86.454,pb:3.699,mktcap:9171253.125,nmc:6226718.125,turnoverratio:4.71454},{symbol:"sh600321",code:"600321",name:"国栋建设",trade:"6.53",pricechange:"0.590",changepercent:"9.933",buy:"6.53",sell:"0.00",settlement:"5.94",open:"5.95",high:"6.53",low:"5.95",volume:134243295,amount:848721771,ticktime:"15:03:06",per:103.651,pb:3.608,mktcap:986389.15,nmc:771114.64,turnoverratio:11.36807},{symbol:"sh600320",code:"600320",name:"振华重工",trade:"9.21",pricechange:"0.830",changepercent:"9.905",buy:"9.21",sell:"9.22",settlement:"8.38",open:"8.45",high:"9.22",low:"8.45",volume:288768803,amount:2605079566,ticktime:"15:03:06",per:204.667,pb:2.736,mktcap:4043461.311864,nmc:2549633.204664,turnoverratio:10.43115},{symbol:"sz300064",code:"300064",name:"豫金刚石",trade:"15.400",pricechange:"1.380",changepercent:"9.843",buy:"15.390",sell:"15.400",settlement:"14.020",open:"14.200",high:"15.420",low:"14.190",volume:31005806,amount:461268844,ticktime:"15:05:54",per:99.355,pb:6.468,mktcap:936320,nmc:932855.02464,turnoverratio:5.11858},{symbol:"sh601880",code:"601880",name:"大连港",trade:"7.94",pricechange:"0.710",changepercent:"9.820",buy:"7.94",sell:"7.95",settlement:"7.23",open:"7.23",high:"7.95",low:"7.18",volume:260090063,amount:2007682855,ticktime:"15:03:06",per:67.517,pb:2.561,mktcap:3514244,nmc:2670539.6,turnoverratio:7.73295},{symbol:"sz002116",code:"002116",name:"中国海诚",trade:"25.21",pricechange:"2.220",changepercent:"9.656",buy:"25.20",sell:"25.21",settlement:"22.99",open:"23.02",high:"25.29",low:"22.81",volume:13306925,amount:321083595,ticktime:"15:05:54",per:32.321,pb:9.392,mktcap:782387.096236,nmc:777451.747141,turnoverratio:4.31496},{symbol:"sz000905",code:"000905",name:"厦门港务",trade:"23.84",pricechange:"2.050",changepercent:"9.408",buy:"23.83",sell:"23.84",settlement:"21.79",open:"22.00",high:"23.97",low:"21.70",volume:64971445,amount:1481214774,ticktime:"15:05:54",per:44.148,pb:4.983,mktcap:1265904,nmc:1265904,turnoverratio:12.23568},{symbol:"sh601007",code:"601007",name:"金陵饭店",trade:"22.31",pricechange:"1.910",changepercent:"9.363",buy:"22.33",sell:"22.35",settlement:"20.40",open:"20.41",high:"22.44",low:"20.41",volume:11398250,amount:250551380,ticktime:"15:03:06",per:167.997,pb:4.913,mktcap:669300,nmc:669300,turnoverratio:3.79942}]';
                    $Content=@file_get_contents(ROOT_PATH.'/Stock/'.$i.'.html');
                    $Encoding=mb_detect_encoding($Content);
                    
                    //所有字符串必须加上双引号
                    $ExplodeList1=explode('{',$Content);
                    $ExplodeList2=array();
                    foreach($ExplodeList1 as $v){
                        $ExplodeList2=array_merge_recursive($ExplodeList2,explode(':',$v));
                    }
                    $ExplodeList3=array();
                    foreach($ExplodeList2 as $v){
                        $ExplodeList3=array_merge_recursive($ExplodeList3,explode(',',$v));
                    }
                    
                    $Content=stripslashes($Content);
                    $ContentUTF8=mb_convert_encoding($Content,'utf-8','gbk');
                    $ContentGBK=mb_convert_encoding($Content,'gbk','utf-8');
                    //$Content=substr($Content,1,strlen($Content)-2);
                    
                    //$Content=str_replace("'", '"',$Content);//将单引替换成双引
                    //preg_replace('/,\s*([\]}])/m', '$1', $Content);//去掉多余的逗号
                    $ContentNew=preg_replace('/(w+)/i', '', $Content);
                    //$p='/^[A-Z].*[A-Z]$/'; $a=preg_replace($p,'','jb51.net');
                    $ContentNew=ereg_replace('[a-z:]+','**@',$Content);
                    
                    $FieldList=array('id',
'amount',
'buy',
'changepercent',
'code',
'high',
'low',
'mktcap',
'name',
'nmc',
'open',
'pb',
'per',
'pricechange',
'sell',
'settlement',
'symbol',
'ticktime',
'trade',
'turnoverratio',
'volume');
                    
                    foreach($FieldList as $v){
                        $Content=str_replace($v,'"'.$v.'"',$Content);
                        $ContentUTF8=str_replace($v,'"'.$v.'"',$ContentUTF8);
                        $ContentGBK=str_replace($v,'"'.$v.'"',$ContentGBK);
                    }
                    $Content=str_replace('"change"per"cent"','"changepercent"',$Content);
                    $ContentUTF8=str_replace('"change"per"cent"','"changepercent"',$ContentUTF8);
                    $ContentGBK=str_replace('"change"per"cent"','"changepercent"',$ContentGBK);
                    $ContentNew1=str_replace('{','{"',$Content);
                    $ContentNew2=ereg_replace('[a-z:]+',"\\1\"",$ContentNew1);
                    $ContentNew3=str_replace(',',',"',$ContentNew2);
                    
                    $new_array=array();
                    $new_array=json_decode($Content);
                    
                    switch (json_last_error()) {
                        case JSON_ERROR_NONE:
                            echo $ErrorInfo=' - No errors';
                            break;
                        case JSON_ERROR_DEPTH:
                            echo $ErrorInfo=' - Maximum stack depth exceeded';
                            break;
                        case JSON_ERROR_STATE_MISMATCH:
                            echo $ErrorInfo=' - Underflow or the modes mismatch';
                            break;
                        case JSON_ERROR_CTRL_CHAR:
                            echo $ErrorInfo=' - Unexpected control character found';
                            break;
                        case JSON_ERROR_SYNTAX:
                            echo $ErrorInfo=' - Syntax error, malformed JSON';
                            break;
                        case JSON_ERROR_UTF8:
                            echo $ErrorInfo=' - Malformed UTF-8 characters, possibly incorrectly encoded';
                            break;
                        default:
                            echo $ErrorInfo=' - Unknown error';
                            break;
                    }
                    
                    echo $ErrorInfo=json_last_error();
                    $ContentGBKJson=json_decode($ContentGBK,true);  
                    $ContentUTF8Json=json_decode($ContentUTF8,true);  
                    $ContentJson=json_decode($ContentUTF8,true);  
                    foreach($ContentJson as $v){                        
                        $StockInfo=M('stock')->where(array('symbol'=>$v['symbol']))->find();
                        if(!$StockInfo){
                            M('stock')->add($v);
                        }
                    }  
                }
            }
            return 2;
        }else{
            return 1;
        }
    }
    public function check(){
        ob_end_clean();
        header("Content-Type:text/html;charset=utf8;");
        ob_start();
        set_time_limit(600);
        $TeamList=M('team')->where('old_id is null')->select();
        foreach($TeamList as $k=>$v){
            $CountData=M('match')->where(array('team_id'=>$v['id']))->count();
            
            $Content=@file_get_contents(ROOT_PATH.'/Stock/'.$v['id'].'.html');
            $ContentJson=json_decode($Content,true);
            $TeamID=M('team')->add(array('old_id'=>$ContentJson['tid']));
            $CountFile=count($ContentJson['list']);
            
            if($CountData!=$CountFile){
                if(file_exists(ROOT_PATH.'/Stock/'.$v['id'].'.html')){
                    echo '<script>parent.PostReturnCallback(\''.'正在检查！'.$v['id'].'\');</script>';  
                    ob_flush();
                    flush();  
                    ob_end_flush();
                    $Content=@file_get_contents(ROOT_PATH.'/Stock/'.$v['id'].'.html');
                    $ContentJson=json_decode($Content,true);
                    M('team')->where(array('id'=>$v['id']))->save(array('old_id'=>$ContentJson['tid']));
                    M('match')->where(array('team_id'=>$v['id']))->delete();
                    $TeamID=$v['id'];
                    foreach($ContentJson['list'] as $k=>$v){
                        $VNew=$v;
                        $VNew['team_id']=$TeamID;
                        $VNew['team_id_old']=$ContentJson['tid'];
                        M('match')->add($VNew);
                    }
                }
            }
        }

        $OutputInfo=json_encode(array('msg'=>'检查成功，操作结束！'.$i,'url'=>U('Stock/Index/Index'),'autoClose'=>'1','type'=>'1'));
        echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;
    }
    public function update(){
        /*ob_end_clean();
        header("Content-Type:text/html;charset=utf8;");
        ob_start();*/
        set_time_limit(600);
        $Min=I('min');
        $Max=I('max');
        if(!(is_numeric($Min)&&is_numeric($Max)&&($Min<=$Max)&&($Min<=3000))){ 
            $OutputInfo=json_encode(array('msg'=>'参数不正确！'.$i,'url'=>U('Stock/Index/Index'),'autoClose'=>'1','type'=>'1'));
            echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;
        }
        M('match')->execute('update ft_team ft set `name`=(SELECT `HOMETEAMSXNAME` from ft_match fm where ft.old_id=fm.HOMETEAMID limit 1) WHERE ft.id>='.$Min.' and ft.id<='.$Max.'');
        
        $Url=U('Stock/Index/Update/?type=team&min='.($Max+1).'&max='.($Max+10));  
        echo '<script>location.href="'.$Url.'";</script>';die;
        /*$OutputInfo=json_encode(array('msg'=>'检查成功，操作结束！'.$i,'url'=>U('Stock/Index/Index'),'autoClose'=>'1','type'=>'1'));
        echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;*/
    }
    public function delete(){
        ob_end_clean();
        header("Content-Type:text/html;charset=utf8;");
        ob_start();
        set_time_limit(600);
        $Min=I('min');
        $Max=I('max');
        for($i=$Min;$i<=$Max;$i++){  
            echo '<script>parent.PostReturnCallback(\''.'正在检查！'.$i.'\');</script>';  
            ob_flush();
            flush();  
            ob_end_flush();
            $Content=@file_get_contents(ROOT_PATH.'/Stock/'.$i.'.html');
            $ContentJson=json_decode($Content,true);
            if(!$ContentJson){
                unlink(ROOT_PATH.'/Stock/'.$i.'.html');
            }
        }
        $OutputInfo=json_encode(array('msg'=>'检查成功，操作结束！'.$i,'url'=>U('Stock/Index/Index'),'autoClose'=>'1','type'=>'1'));
        echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;
    }
    public function save(){
           
    }
    public function get(){
        ob_end_clean();
        header("Content-Type:text/html;charset=utf8;");
        ob_start();
        set_time_limit(500);
        $Min=I('min');
        $Max=I('max');
        if(is_numeric($Min)&&is_numeric($Max)&&($Min<=$Max)){
            for($i=$Min;$i<=$Max;$i++){
                if(!file_exists(ROOT_PATH.'/Stock/'.$i.'.html')){
                    echo '<script>parent.PostReturnCallback(\''.'正在获取！'.$i.'\');</script>';  
                    ob_flush();
                    flush();  
                    ob_end_flush();
                    MakeHtml(ROOT_PATH.'/Stock/'.$i.'.html','http://vip.stock.finance.sina.com.cn/quotes_service/api/json_v2.php/Market_Center.getHQNodeData?page='.$i.'&num=80&sort=changepercent&asc=0&node=hs_a&symbol=&_s_r_a=setlen','');
                }
            }
            $OutputInfo=json_encode(array('msg'=>'获取成功，操作结束！'.$i,'url'=>U('Stock/Index/Index'),'autoClose'=>'1','type'=>'1'));
            echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;
            //echo '获取成功！';
        }else{
            $OutputInfo=json_encode(array('msg'=>'参数不正确！'.$i,'url'=>U('Stock/Index/Index'),'autoClose'=>'1','type'=>'1'));
            echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;
            //echo '参数不正确！';
        }
    }
    public function getdata(){
        ob_end_clean();
        header("Content-Type:text/html;charset=utf8;");
        ob_start();
        set_time_limit(5000);
        $Min=I('min');
        $Max=I('max');
        if(is_numeric($Min)&&is_numeric($Max)&&($Min<=$Max)){
            $SrockList=M('stock')->select();
            foreach($SrockList as $v){
                if(!file_exists(ROOT_PATH.'/Stock/data/'.$v['symbol'].'.html')){
                    echo '<script>parent.PostReturnCallback(\''.'正在获取！'.$v['symbol'].'\');</script>';  
                    ob_flush();
                    flush();  
                    ob_end_flush();
                    $StockCode=substr($v['symbol'],2);
                    
                    MakeHtml(ROOT_PATH.'/Stock/data/'.$v['symbol'].'.html','http://img1.money.126.net/data/hs/time/4days/0'.$StockCode.'.json?callback=ne3de23ad4bdf098','');
                }
            }
            $OutputInfo=json_encode(array('msg'=>'获取成功，操作结束！'.$i,'url'=>U('Stock/Index/Index'),'autoClose'=>'1','type'=>'1'));
            echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;
            //echo '获取成功！';
        }else{
            $OutputInfo=json_encode(array('msg'=>'参数不正确！'.$i,'url'=>U('Stock/Index/Index'),'autoClose'=>'1','type'=>'1'));
            echo '<script>parent.PostReturnIframeCallback(\''.$OutputInfo.'\');</script>';die;
            //echo '参数不正确！';
        }
    }
}