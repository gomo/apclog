#apclog

## Usage

### IpCount

```
php apclog IpCount /path/to/logfile[ 'grep regex'...]
```

#### option
-n IP存在確認用のデータを更新しない

#### ex

for google
```
php apclog IpCount access.log 'GET / HTTP/1\.1' 'www\.google\.co\.jp'
```

for yahoo
```
php apclog IpCount access.log 'GET / HTTP/1\.1' 'search\.yahoo\.co\.jp'
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




## license
MIT
