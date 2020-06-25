function confirmPostDeletion(link)
    {
        let r = confirm("Confirm Post DELETION");
        if (r == true) {
            let xhttp = new XMLHttpRequest;

            xhttp.open("POST", link, true);
            xhttp.send();
            location.reload();
        }
    }

    function comment(post_id)
    {
        let comment_body = document.getElementById('comment_body_post_'+post_id).value;

        if(comment_body.length<1) {alert("empty comment"); return false;}

        let xhttp = new XMLHttpRequest;
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let holder = document.getElementById("all_comments_for_"+post_id).innerHTML;
                let new_comment = xhttp.responseText;

                document.getElementById("all_comments_for_"+post_id).innerHTML = new_comment + holder;
            }
        };
        xhttp.open("POST","/social_site/public/comment/newComment", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send("comment_body="+comment_body+"&post_id="+post_id);
    }

    function deleteComment(comment_id)
    {
        if(comment_id < 0) return false;

        let xhttp = new XMLHttpRequest();

        xhttp.open("POST", "/social_site/public/comment/deleteComment/"+comment_id, true);
        xhttp.send();

        location.reload();
    }

    function upvote_post(post_id)
    {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) 
            {
                document.getElementById('upvote_post_'+post_id).innerHTML = xhttp.responseText;
                document.getElementById('downvote_post_'+post_id).innerHTML = "downvote";

            }
        };
        xhttp.open("GET", "/social_site/public/post/upvote"+"/"+post_id, true);
        xhttp.send();
    }

    function downvote_post(post_id)
    {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) 
            {
                document.getElementById('downvote_post_'+post_id).innerHTML = xhttp.responseText;
                document.getElementById('upvote_post_'+post_id).innerHTML = "upvote";
            }
        };
        xhttp.open("GET", "/social_site/public/post/downvote"+"/"+post_id, true);
        xhttp.send();
    }

    function upvote(comment_id)
    {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) 
            {
                document.getElementById('upvote_'+comment_id).innerHTML = xhttp.responseText;
                document.getElementById('downvote_'+comment_id).innerHTML= "downvote";
            }
        };
        xhttp.open("GET", "/social_site/public/comment/upvote"+"/"+comment_id, true);
        xhttp.send();
    }

    function downvote(comment_id)
    {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) 
            {
                document.getElementById('downvote_'+comment_id).innerHTML = xhttp.responseText;
                document.getElementById('upvote_'+comment_id).innerHTML= "upvote";
            }
        };
        xhttp.open("GET", "/social_site/public/comment/downvote"+"/"+comment_id, true);
        xhttp.send();
    }

    function follow(to_follow)
    {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange= function()
        {
            if(this.readyState==4 && this.status==200)
            {
                document.getElementById("follow_btn").innerHTML = xhttp.responseText;
            }
        };

        xhttp.open("GET", "/social_site/public/auth/follow/"+to_follow, true);
        xhttp.send();
    }
