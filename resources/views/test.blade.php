
<!doctype html>
<html>
<head>
    <style>
        body{
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        div.feed-container{
            position: relative;
            border: 1px solid rgb(198, 198, 198);
            padding: 10px;
        }
        div.image-container, div.name{
            display: inline-block;
        }
        div.credentials p{
            margin:0;
        }
        div.image-container img{
            width: 60px;
        }
        div.name{
            padding-left: 10px;
            position: absolute;
            top: 10px;
        }
        div.name p:first-child{
            font-weight: 600;
        }
        div.name p:nth-child(2){
            font-size: 0.8em;
            color: #585858;
        }
        div.footer{
            background-color: rgb(194, 194, 194);
        }
        div.footer a{
            display: inline-block;
            margin:10px 0;
            padding:0 10px;
            padding-right:13px;
            border-right: 1px solid grey;
        }
        div.footer a:last-child{
            border-right: none;
        }
    </style>
</head>
<body>
<h1>App</h1>
<hr />

<p>Xavier Au posted in Island Crest.</p>
<div class="feed-container">
    <div class="credentials">
        <div class="image-container">
            <img src="https://scontent.xx.fbcdn.net/hprofile-xpl1/v/t1.0-1/c20.0.120.120/p120x120/10609606_10153280228250239_4668076210456070353_n.jpg?oh=0d0919a5591ba02db89216bf8b58e265&amp;oe=57B7DD1D">
        </div>
        <div class="name">
            <p>Xavier Au</p>
            <p>Apr 27 at 1:55pm</p>
        </div>
    </div>

    <p>my new feed</p>
</div>

<div class="footer">
    <a href="#">Like</a>
    <a href="#">Comment</a>
</div>
</body>

</html>
