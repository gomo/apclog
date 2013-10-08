#apclog

## Usage

### IpCount
```
/usr/local/bin/php apclog IpCount /path/to/logfile[ 'grep regex'...]
```

IP毎のカウントを集計して表示。毎回IPアドレスのリストをキャッシュし新しく現れたものが分かるように出力。

#### option
-n IP存在確認用のキャッシュデータを更新しない。
-m1 出力するカウントの最小値

#### ex

for google
```
/usr/local/bin/php apclog IpCount access.log 'GET / HTTP/1\.1' 'www\.google\.co\.jp'
```

option
```
/usr/local/bin/php apclog -m5 -n IpCount access.log 'GET / HTTP/1\.1' 'www\.google\.co\.jp'
```

for yahoo
```
/usr/local/bin/php apclog IpCount access.log 'GET / HTTP/1\.1' 'search\.yahoo\.co\.jp'
```

Result
```
Exists
6       : 123.456.78.90
3       : 123.456.78.91

New
6       : 123.456.78.92
3       : 123.456.78.93
19      : 123.456.78.94
4       : 123.456.78.95
7       : 123.456.78.96
```

### IpReport
```
/usr/local/bin/php apclog IpReport /path/to/logfile[ 'grep regex'...]
```

アクセスの多かったIPアドレスからの詳細ログをレポートします。

#### option
-m1 出力するカウントの最小値

#### ex

for google
```
/usr/local/bin/php apclog IpReport access.log 'GET / HTTP/1\.1' 'www\.google\.co\.jp'
```

for yahoo
```
/usr/local/bin/php apclog IpReport access.log 'GET / HTTP/1\.1' 'search\.yahoo\.co\.jp'
```

Result
```
123.456.78.90 - 7
123.456.78.90 - - [07/Oct/2013:12:08:28 +0900] "GET / HTTP/1.1" 200 24639 "http://search.yahoo.co.jp/search?p=someword&ei=UTF-8&fr=applep1&pcarrier=KDDI&pmcc=440&pmnc=50" "Mozilla/5.0 (iPhone; CPU iPhone OS 7_0_1 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11A470a Safari/9537.53"
...
```

## license
MIT
