window.onload = function(){
      
      //トップへスクロール
      var toTop = jQuery(".to_top");
      toTop.click(function(){
            jQuery('body,html').animate({scrollTop: 0}, 800);
            return false;
            }
      );

      //コメント入力欄スライドイン
      var bt_go_input = jQuery(".comment_open");
      var input = jQuery(".comment-form");

      bt_go_input.click(function(){
            if(input.css("display")=="none"){
                  input.slideDown('normal', function(){bt_go_input.html("up 閉じる");});
            }else{
                  input.slideUp('normal', function(){bt_go_input.html("down コメントを残す");});
            }
      });

      //サイドバー処理
      var screen_width = jQuery(window).width(); //画面横幅取得
      var border = 1129; //サイドバー有無の境目

      var sideWrap = jQuery(".side"); //サイドバーの外枠

      if(screen_width > border){ //PCの場合（サイドバー追尾処理）
            var mainArea = jQuery(".main"); //メインコンテンツ
            var sideArea = jQuery(".side_inner"); //サイドバー中身

            var wd = jQuery(window); //ウィンドウ自体
       
            //メインとサイドの高さを比べる       
            var mainH = mainArea.height();
            var sideH = sideWrap.height();

            if(sideH < mainH) { //メインの方が高ければ色々処理する
             
                  //サイドバーの外枠をメインと同じ高さにしてrelaltiveに（#sideをポジションで上や下に固定するため）
                  sideWrap.css({"height": mainH,"position": "relative"});
       
                  //サイドバーがウィンドウよりいくらはみ出してるか
                  var sideOver = wd.height()-sideArea.height();
       
                  //固定を開始する位置 = サイドバーの座標＋はみ出す距離
                  var starPoint = sideArea.offset().top + (-sideOver);
             
                  //固定を解除する位置 = メインコンテンツの終点
                  var breakPoint = sideArea.offset().top + mainH;
       
                  wd.scroll(function() { //スクロール中の処理
                   
                        if(wd.height() < sideArea.height()){ //サイドメニューが画面より大きい場合
                              if(starPoint < wd.scrollTop() && wd.scrollTop() + wd.height() < breakPoint){ //固定範囲内
                                    sideArea.css({"position": "fixed", "bottom": "0"}); 
       
                              }else if(wd.scrollTop() + wd.height() >= breakPoint){ //固定解除位置を超えた時
                                    sideArea.css({"position": "absolute", "bottom": "-30px"});
       
                              } else { //その他、上に戻った時
                                    sideArea.css("position", "relative");
       
                              }
       
                        }else{ //サイドメニューが画面より小さい場合
                   
                              var sideBtm = wd.scrollTop() + sideArea.height(); //サイドメニューの終点
                         
                              if(mainArea.offset().top < wd.scrollTop() && sideBtm < breakPoint){ //固定範囲内
                                    sideArea.css({"position": "fixed", "top": "0"});
                                     
                              }else if(sideBtm >= breakPoint){ //固定解除位置を超えた時
                         
                                    //サイドバー固定場所（bottom指定すると不具合が出るのでtopからの固定位置を算出する）
                                    var fixedSide = mainH - sideH;
                               
                                    sideArea.css({"position": "absolute", "top": fixedSide});
                               
                              } else {
                                    sideArea.css("position", "relative");
                              }
                        }
                         
             
                  });
            }
      }else{ //PC以外の場合（サイドバースライドイン処理）
            jQuery(function(){
                  sideWrap.addClass("drawer-nav");
                  sideWrap.css("display", "block");//読み込み終了までnone
            });
            //jQuery('.drawer').drawer();
            
            var toggle_button = jQuery(".drawer-toggle");
            var body = jQuery("body");

            toggle_button.click(function(){
                  if(!body.hasClass("drawer-open")){
                        body.removeClass("drawer-close");
                        body.addClass("drawer-open");
                        body.css("overflow", "hidden");
                        sideWrap.css("overflow-x", "scroll");
                  }else{
                        body.removeClass("drawer-open");
                        body.addClass("drawer-close");
                        body.css("overflow", "auto");
                  }
            });
            
      }    

}
 