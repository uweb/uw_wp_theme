jQuery(".uw-recent a.feed").off("click").on("click",function(e){e.preventDefault(),jQuery(".uw-recent p.feed").toggleClass("hide"),jQuery(".uw-recent p.feed > input").trigger("select")});