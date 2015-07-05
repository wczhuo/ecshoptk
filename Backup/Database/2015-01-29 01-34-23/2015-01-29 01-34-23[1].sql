set sql_mode='';
DROP TABLE IF EXISTS phpyun_website;
CREATE TABLE phpyun_website (
  id int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0',
  price int(11) NOT NULL DEFAULT '0',
  smallday int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=gbk;
DROP TABLE IF EXISTS phpyun_zhaopinhui;
CREATE TABLE phpyun_zhaopinhui (
  id int(11) NOT NULL AUTO_INCREMENT,
  title varchar(200) DEFAULT '0' COMMENT '招聘会标题',
  pic varchar(200) DEFAULT '0' COMMENT '招聘会图像',
  starttime varchar(100) DEFAULT '0' COMMENT '开始时间',
  endtime varchar(100) DEFAULT '0' COMMENT '结束时间',
  provinceid int(11) DEFAULT '0' COMMENT '一级城市',
  cityid int(11) DEFAULT '0' COMMENT '二级城市',
  address varchar(200) DEFAULT NULL COMMENT '会场地址',
  traffic text COMMENT '交通路线',
  phone varchar(100) DEFAULT '0' COMMENT '咨询电话',
  organizers varchar(200) DEFAULT '0' COMMENT '主办方',
  `user` varchar(200) DEFAULT NULL COMMENT '联系人',
  weburl varchar(100) DEFAULT '0' COMMENT '网址',
  body text COMMENT '招聘会介绍',
  media text COMMENT '媒体宣传',
  packages text COMMENT '服务套餐',
  booth text COMMENT '展位设置方案',
  participate text COMMENT '参与办法',
  `status` int(11) DEFAULT '0' COMMENT '审核',
  ctime int(11) DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=gbk;
INSERT INTO phpyun_website VALUES('1','1','2','2');
INSERT INTO phpyun_website VALUES('2','2','1','1');
INSERT INTO phpyun_website VALUES('3','3','3','3');
INSERT INTO phpyun_website VALUES('4','4','4','4');
INSERT INTO phpyun_website VALUES('5','5','5','5');
INSERT INTO phpyun_website VALUES('6','6','6','6');
INSERT INTO phpyun_zhaopinhui VALUES('1','北京大型人才交流会','/upload/kindeditor/image/20141117/20141117160150_10593.png','2014-06-22','2014-08-08','0','0','人民大会堂','5644号线','010-800-4869','北京人力资源中心','张小姐','www.job.com','北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会北京大型人才交流会','速度赶赴各地房价的感&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 到很孤独范&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 甘迪范甘迪个<br />','速度赶赴各地&nbsp;&nbsp;&nbsp;&nbsp; 房价的感&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 到很孤独范&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 甘迪范甘迪个<br />','速度赶赴各地&nbsp;&nbsp;&nbsp;&nbsp; 房价似懂非懂是的感&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 豆腐干地方 &nbsp;&nbsp;&nbsp;&nbsp; 到很孤独范&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 甘迪范甘迪个<br />','抽奖','0','1342157533');
INSERT INTO phpyun_zhaopinhui VALUES('2','2012年7月猎才高层次人才邀约面试会','','2014-12-22','2015-02-27','0','0','上海光大会展中心',' 07、15、42、43、49、56、73、8992、104、120、138、218、251、401、524、526、704、718、923、764、808、824、847、857、872、826、827、832、地铁一号线、大桥六线、隧道二线、 地铁3/4号线','021 - 3126 3776','中国招聘中心','黄小姐','www.hr135.com','上海东亚展览馆招聘会通常是综合大型招聘会，凭借着优越的地理位置，便利的交通，一直是上海招聘会中人气最旺的一家，可同时容纳400 家单位进行招聘。行业覆盖面广、信息量大。涉及IT 电子、信息通信、机械制造、投资营销外贸、贸易服装、综合以及广告文艺等行业。场馆内参展企业按不同行业划分，安排到不同的看台，并且各看台都有明确的行业指示，招聘应聘的配套服务齐全。凸现“平民”特点，汇聚了各个行业，以中小企业为主。高、中、低层次求职者都有机会。<br />\r\n<p>\r\n	<br />\r\n</p>','<p>\r\n	1、本次招聘会将在前程无忧上海站每周漂浮广告《人才市场报》每周整版广告、人才市场报电子版、上才网<a href=\"http://www.jober.cn/\">www.021cai.com</a>、以及《中华英才网》等 媒体上做广泛宣传。\r\n</p>','<p>\r\n	1、本次招聘会将在前程无忧上海站每周漂浮广告《人才市场报》每周整版广告、人才市场报电子版、上才网<a href=\"http://www.jober.cn/\">www.021cai.com</a>、以及《中华英才网》等 媒体上做广泛宣传。<br />\r\n2、提供当日二人午餐、饮料、文具；标准铝合金搭建3m×1m(内设两个标准展位)；<br />\r\n3、将参会费汇至下面账户，我们将按照收到汇款日期的先后安排参会单位展位；<br />\r\n4、会前付费可免费制作海报一张（90*120cm彩色喷墨限500字）。<br />\r\n5、优惠活动：现在订<a href=\"http://www.jober.cn/Info/\">招聘会</a>加100元可开通上海才市网(<a href=\"http://www.jober.cn/Html/JobFair/80.html\">www.021cai.com</a>)网络招聘一个月(价值280元)。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>','<p>\r\n	周六：标准展位：600元（1.5*1M）、独立展位：1200元(2*1M)&nbsp; 、精装展位：2200元(3*2M)、VIP展位：2800元(3*3M)\r\n</p>\r\n<p>\r\n	<br />\r\n</p>','时间：2012年7月7、14、21、28日（周六： 9:00—14:30）<br />\r\n<p>\r\n	按行业或专业特色，划分十五大专区：\r\n</p>\r\n<p>\r\n	●IT.电子.计算机.通讯类\r\n</p>\r\n<p>\r\n	●航运.货代.陆运.运输.外贸类\r\n</p>\r\n<p>\r\n	●综合类\r\n</p>\r\n<p>\r\n	●普工.技工.操作工类\r\n</p>\r\n<p>\r\n	●商场.卖场.百货.批发零售类\r\n</p>\r\n<p>\r\n	●汽车.电器.机械.模具类\r\n</p>\r\n<p>\r\n	●投资.金融.证券.期货类\r\n</p>\r\n<p>\r\n	●酒店.餐饮.旅游.娱乐.美容(发)类\r\n</p>\r\n<p>\r\n	●市场.营销.业务类\r\n</p>\r\n<p>\r\n	●服装.服饰.纺织类\r\n</p>\r\n<p>\r\n	●房地产.建筑.装潢.物业类\r\n</p>\r\n<p>\r\n	●教育.教师.培训机构类\r\n</p>\r\n<p>\r\n	●广告.文化.印务.包装类\r\n</p>\r\n●食品.生物.化工.化学.制药.医疗类<br />\r\n<span style=\"color:#ff7f00;\"><span style=\"color:#000000;\"><br />\r\n</span></span>','0','1342159048');
INSERT INTO phpyun_zhaopinhui VALUES('8','phpyun系统关于我们','0','2014-12-09','2016-12-16','0','0','上海','101','010-83765555','上海','张小姐','www.baidu.com','上海东亚展览馆招聘会通常是综合大型招聘会，凭借着优越的地理位置，便利的交通，一直是上海招聘会中人气最旺的一家，可同时容纳400家单位进行招聘。行\r\n业覆盖面广、信息量大。涉及IT电子、信息通信、机械制造、投资营销外贸、贸易服装、综合以及广告文艺等行业。场馆内参展企业按不同行业划分，安排到不同\r\n的看台，并且各看台都有明确的行业指示，招聘应聘的配套服务齐全。','上海东亚展览馆招聘会通常是综合大型招聘会，凭借着优越的地理位置，便利的交通，一直是上海招聘会中人气最旺的一家，可同时容纳400家单位进行招聘。行\r\n业覆盖面广、信息量大。涉及IT电子、信息通信、机械制造、投资营销外贸、贸易服装、综合以及广告文艺等行业。场馆内参展企业按不同行业划分，安排到不同\r\n的看台，并且各看台都有明确的行业指示，招聘应聘的配套服务齐全。','上海东亚展览馆招聘会通常是综合大型招聘会，凭借着优越的地理位置，便利的交通，一直是上海招聘会中人气最旺的一家，可同时容纳400家单位进行招聘。行\r\n业覆盖面广、信息量大。涉及IT电子、信息通信、机械制造、投资营销外贸、贸易服装、综合以及广告文艺等行业。场馆内参展企业按不同行业划分，安排到不同\r\n的看台，并且各看台都有明确的行业指示，招聘应聘的配套服务齐全。','上海东亚展览馆招聘会通常是综合大型招聘会，凭借着优越的地理位置，便利的交通，一直是上海招聘会中人气最旺的一家，可同时容纳400家单位进行招聘。行\r\n业覆盖面广、信息量大。涉及IT电子、信息通信、机械制造、投资营销外贸、贸易服装、综合以及广告文艺等行业。场馆内参展企业按不同行业划分，安排到不同\r\n的看台，并且各看台都有明确的行业指示，招聘应聘的配套服务齐全。','上海东亚展览馆招聘会通常是综合大型招聘会，凭借着优越的地理位置，便利的交通，一直是上海招聘会中人气最旺的一家，可同时容纳400家单位进行招聘。行\r\n业覆盖面广、信息量大。涉及IT电子、信息通信、机械制造、投资营销外贸、贸易服装、综合以及广告文艺等行业。场馆内参展企业按不同行业划分，安排到不同\r\n的看台，并且各看台都有明确的行业指示，招聘应聘的配套服务齐全。','0','1406682563');
INSERT INTO phpyun_zhaopinhui VALUES('11','sss','0','2015-01-30','2017-01-13','0','0','道道道','http://www.job.com','13918988776','111','111','1111','111','','','','','0','1421483540');
