<style>
    .mailbody{
        display: flex;
        justify-items: center;
        align-items: center;
    }

    .mailbody p{
        text-align: center;
    }

    .mailbody span{
        font-size: 15px
    }

    .toplogo{
        width: 300px;
        height: auto;
    }
</style>
<div class="mailbody">
    <p style="font-weight: 700">New Message Recieved from Alumni Archive</p>
    <p style="font-size: 18px"><span>From:</span> {{ $messageData['name'] }}</p>
    <p style="font-size: 15px"><span>Reply to:</span> {{ $messageData['email'] }}</p>
    <p style="font-size: 25px"><span style="font-size: 15px">Message:</span> <br> {{ $messageData['message'] }}</p>
</div>
