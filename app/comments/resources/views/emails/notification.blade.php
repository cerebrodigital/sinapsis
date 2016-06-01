<?php $message->subject('New comment from '.$authorName); ?>

From: {{ $authorName }}<br>
Email: {{ $authorEmail }}<br>
IP: {{ $authorIp }}<br>
Status: {{ $status }}<br>
Date: {{ $createdAt }}<br>
Permalink: <a href="{{ $permalink }}">{{ $permalink }}</a><br>
Edit link: <a href="{{ $editLink }}">{{ $editLink }}</a><br>
<div style="color: #555;">
{{ $content }}
</div>
