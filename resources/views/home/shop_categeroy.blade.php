@include('home.header')


<!--================Blog Area =================-->
  <section class="blog_area section_gap">
      <div class="container">
          <div class="row">
              <div class="col-lg-8 mb-5 mb-lg-0">
                  <div class="blog_left_sidebar">
                      <article class="blog_item">
                        <div class="blog_item_img">
                          <img class="card-img rounded-0" src="img/blog/main-blog/m-blog-1.jpg" alt="">
                          <a href="#" class="blog_item_date">
                            <h3>15</h3>
                            <p>Jan</p>
                          </a>
                        </div>
                        
                        <div class="blog_details">
                            <a class="d-inline-block" href="single-blog.html">
                                <h2>Google inks pact for new 35-storey office</h2>
                            </a>
                            <p>That dominion stars lights dominion divide years for fourth have don't stars is that he earth it first without heaven in place seed it second morning saying.</p>
                            <ul class="blog-info-link">
                              <li><a href="#"><i class="ti-user"></i> Travel, Lifestyle</a></li>
                              <li><a href="#"><i class="ti-comments"></i> 03 Comments</a></li>
                            </ul>
                        </div>
                      </article>
                  </div>
              </div>
              <div class="col-lg-4">
                  <div class="blog_right_sidebar">
                      <aside class="single_sidebar_widget search_widget">
                          <form action="#">
                            <div class="form-group">
                              <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Search Keyword">
                                <div class="input-group-append">
                                  <button class="btn" type="button"><i class="ti-search"></i></button>
                                </div>
                              </div>
                            </div>
                            <button class="main_btn rounded-0 w-100" type="submit">Search</button>
                          </form>
                      </aside>

                      <aside class="single_sidebar_widget post_category_widget">
                        <h4 class="widget_title">Category</h4>
                        <ul class="list cat-list">
                            @foreach ($categories as $category)
                            <li>
                                <a href="#">{{ $category->c_name }}</a>
                            </li>
                            @endforeach
                        </ul>
                      </aside>

                   
                  </div>
              </div>
          </div>
      </div>
  </section>
  <!--================Blog Area =================-->

@include('home.footer')