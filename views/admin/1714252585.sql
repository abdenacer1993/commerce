

CREATE TABLE `about` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `about` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO about VALUES("1","Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius enim, accusantium repellat ex autem numquam iure officiis facere vitae itaque?

Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam qui vel cupiditate exercitationem, ea fuga est velit nulla culpa modi quis iste tempora non, suscipit repellendus labore voluptatem dicta amet?

Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam qui vel cupiditate exercitationem, ea fuga est velit nulla culpa modi quis iste tempora non, suscipit repellendus labore voluptatem dicta amet?");





CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO admin VALUES("1","admin","$2y$10$MilDJm3l8BP.0xHChL/liOBpFEQcHaW3gejq.SuQYfs459KDgwhR.");





CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO categories VALUES("5","pc portable");
INSERT INTO categories VALUES("6","Telephone");





CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `value` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO contact VALUES("1","address","123 ABC Street, XYZ Road");
INSERT INTO contact VALUES("2","phone","+234-80-1234-5678");
INSERT INTO contact VALUES("3","facebook","username");
INSERT INTO contact VALUES("4","twitter","username");
INSERT INTO contact VALUES("5","instagram","username");
INSERT INTO contact VALUES("6","email","info@abc.com");





CREATE TABLE `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(1000) NOT NULL,
  `answer` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO faq VALUES("1","What is my name?","Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip");
INSERT INTO faq VALUES("4","Who am i?","I dont know");





CREATE TABLE `policy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `policy` varchar(25000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO policy VALUES("1","Copyright 2011-2018 Twitter, Inc.

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the \"Software\"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED \"AS IS\", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.");





CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) NOT NULL,
  `price` double NOT NULL,
  `description` varchar(1000) NOT NULL,
  `category` varchar(500) NOT NULL,
  `images` varchar(2000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO products VALUES("1","test","800","sqdqsd","pc portable","a:1:{i:0;s:36:\"08735801154dea83a6a86ccfb235213a.jpg\";}");
INSERT INTO products VALUES("4","test","1200","new pc","pc portable","a:1:{i:0;s:36:\"594df1cdf2b8975f62a08e2d6c64919d.jpg\";}");
INSERT INTO products VALUES("5","oui","123123","OUI","pc portable","a:1:{i:0;s:36:\"2f5daf0d9240e1461e4c02083f4a7b03.jpg\";}");
INSERT INTO products VALUES("6","az","123123","jhsdfhkqsdf","pc portable","a:3:{i:0;s:36:\"58c38366ec9a7fc9c1d4eb6436e50bdf.jpg\";i:1;s:36:\"0288773c867735bbd28604dfe9700e17.jpg\";i:2;s:36:\"29639e1a17ecd1aa663b57c62088465c.jpg\";}");
INSERT INTO products VALUES("7","iphone","2500","iphone","Telephone","a:1:{i:0;s:36:\"352a2a90183bc404c3af07af47d1957e.jpg\";}");





CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `details` varchar(1000) NOT NULL,
  `timestamp` datetime NOT NULL,
  `address` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO transactions VALUES("1","ben nacer nacer","nacer@gmail.com","a:1:{i:6;a:7:{s:2:\"id\";s:1:\"6\";s:5:\"title\";s:2:\"az\";s:5:\"price\";s:6:\"123123\";s:11:\"description\";s:11:\"jhsdfhkqsdf\";s:8:\"category\";s:11:\"pc portable\";s:8:\"quantity\";s:1:\"1\";s:5:\"image\";s:36:\"58c38366ec9a7fc9c1d4eb6436e50bdf.jpg\";}}","2024-04-02 09:26:29","Gafsa 2151");
INSERT INTO transactions VALUES("2","ben nacer nacer","nacer@gmail.com","a:1:{i:6;a:7:{s:2:\"id\";s:1:\"6\";s:5:\"title\";s:2:\"az\";s:5:\"price\";s:6:\"123123\";s:11:\"description\";s:11:\"jhsdfhkqsdf\";s:8:\"category\";s:11:\"pc portable\";s:8:\"quantity\";s:1:\"1\";s:5:\"image\";s:36:\"58c38366ec9a7fc9c1d4eb6436e50bdf.jpg\";}}","2024-04-02 09:27:46","Gafsa 2151");
INSERT INTO transactions VALUES("3","ben nacer nacer","abdenacer1993@gmail.com","a:1:{i:6;a:7:{s:2:\"id\";s:1:\"6\";s:5:\"title\";s:2:\"az\";s:5:\"price\";s:6:\"123123\";s:11:\"description\";s:11:\"jhsdfhkqsdf\";s:8:\"category\";s:11:\"pc portable\";s:8:\"quantity\";s:1:\"1\";s:5:\"image\";s:36:\"58c38366ec9a7fc9c1d4eb6436e50bdf.jpg\";}}","2024-04-02 09:31:10","Gafsa 2151");





CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(250) NOT NULL,
  `password` varchar(200) NOT NULL,
  `code` int(11) NOT NULL DEFAULT '0',
  `expiration` int(11) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

INSERT INTO users VALUES("10","ben nacer","nacer","abdenacer1993@gmail.com","23122312","Gafsa 2151","$2y$10$MPJDY.eXHj4XFNdFtsT1gunyBmxfy0JmIOOI6ODHuk6lCPwIW3dDi","0","0","1712015490");
INSERT INTO users VALUES("11","ben test","test ","test@gmail.com","23455666","gafsa","$2y$10$Z6UY0Te1t5VYC162B9GBnOztSyKBPzLssOMeADXmLmjIPz90kGcGO","0","0","1714251738");



