<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remastered Layout</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    
    <style>
        .post-content-container {
            transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94); /* Smooth transition for content changes */
            transform: translateY(0);
        }

        .post-content-container.animate-out {
            opacity: 0;
            transform: translateY(-10px);
        }

        .post-content-container.animate-in {
            opacity: 1;
            transform: translateY(0);
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: invert(1);
        }
        
        .carousel-aspect-ratio-wrapper {
            height: 100%;
        }

        #carouselExample,
        .carousel-inner,
        .carousel-item {
            height: 100%;
        }
        
        .carousel-item img {
             width: 100%;
             height: 100%;
             object-fit: cover;
        }
    </style>
</head>
<body class="font-sans bg-gray-50 h-screen overflow-hidden">

<div class="container mx-auto px-4 md:px-8 h-full pt-4">
    
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 h-full pb-4">

        <div class="lg:col-span-3 h-full mb-6 lg:mb-0">
            <?php $photos = $this->db->get('carousel_photos')->result_array(); ?>

            <?php if (!empty($photos)): ?>
                <div class="carousel-aspect-ratio-wrapper shadow-xl rounded-xl">
                    <div id="carouselExample" class="carousel slide carousel-fade mx-auto h-full" data-interval="false">

                        <ol class="carousel-indicators">
                        <?php foreach ($photos as $index => $photo): ?>
                            <li data-target="#carouselExample" data-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?> bg-red-600"></li>
                        <?php endforeach; ?>
                        </ol>

                        <div class="carousel-inner rounded-xl h-full">
                        <?php foreach ($photos as $index => $photo): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?> h-full flex items-center justify-center bg-gray-900">
                            <img src="<?= base_url('assets/uploads/carousel/' . $photo['file_name']) ?>" 
                                 class="d-block rounded-xl" 
                                 alt="Slide <?= $index + 1 ?>" 
                                 onerror="this.onerror=null; this.src='https://placehold.co/960x500/fca5a5/7f1d1d?text=Image+Placeholder';">
                            </div>
                        <?php endforeach; ?>
                        </div>

                        <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                        </a>

                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="lg:col-span-2 h-full flex flex-col justify-between gap-6">
        <?php foreach ($grouped_posts as $type => $posts): ?>
            <?php
            $post_data = [];
            foreach ($posts as $post) {
                $post_data[] = [
                    'id' => $post->id,
                    'title' => $post->title,
                    'date' => date('F j, Y', strtotime($post->created_at))
                ];
            }
            $post_data_json = htmlspecialchars(json_encode($post_data), ENT_QUOTES, 'UTF-8');
            ?>
            <section class="flex-grow bg-white rounded-xl shadow-lg p-4 flex flex-col justify-between border-t border-gray-200 overflow-hidden" 
                     data-post-type="<?= $type ?>" 
                     data-posts="<?= $post_data_json ?>" 
                     data-current-index="0">
                
                <div>
                    <h3 class="post-category-title text-xl font-extrabold mb-2 text-red-800 capitalize">
                        <?= ucfirst($type) ?>
                    </h3>

                    <?php if (!empty($posts)): ?>
                        <div class="post-content-container animate-in">
                            <h4 class="post-title text-md font-bold mb-1 text-gray-900 leading-tight">
                                <?= $posts[0]->title ?>
                            </h4>
                            <p class="post-date text-xs text-gray-500 mb-2">
                                <?= date('F j, Y', strtotime($posts[0]->created_at)) ?>
                            </p>
                        </div>
                    <?php else: ?>
                        <p class="text-sm text-gray-500">No <?= $type ?> posts available.</p>
                    <?php endif; ?>
                </div>
                
                <div class="mt-auto pt-3 flex justify-between items-center">
                    <?php if (!empty($posts)): ?>
                        <a href="#" 
                            class="read-more-link text-red-600 hover:text-red-800 text-sm font-medium transition duration-200" 
                            data-toggle="modal" 
                            data-target="#postModal<?= $posts[0]->id ?>">
                            View Latest &rarr;
                        </a>
                        <?php if (count($posts) > 1): ?>
                            <button class="next-post-btn px-3 py-1 bg-red-600 text-white text-xs font-bold rounded-full hover:bg-red-700 transition duration-150">
                                Next &gt;
                            </button>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <?php foreach ($posts as $post): ?>
                    <div class="modal fade" id="postModal<?= $post->id ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content rounded-xl shadow-2xl">
                                <div class="modal-header bg-red-800 text-white rounded-t-xl">
                                    <h5 class="modal-title text-2xl font-bold"><?= $post->title ?></h5>
                                    <button type="button" class="close text-white opacity-100 hover:opacity-75" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body p-6">
                                    <?php if ($post->image): ?>
                                        <img src="<?= base_url('assets/uploads/post/' . $post->image) ?>" 
                                            alt="<?= $post->title ?>" 
                                            class="w-full h-64 object-cover rounded-lg mb-4"
                                            onerror="this.onerror=null; this.src='https://placehold.co/600x256/fca5a5/7f1d1d?text=Post+Image';"
                                        />
                                    <?php endif; ?>
                                    <div class="text-gray-700 leading-relaxed">
                                        <?= $post->content ?>
                                    </div>
                                    <p class="mt-4 text-sm text-gray-500">
                                        <span class="font-medium">Posted on:</span> <?= date('F j, Y, g:i a', strtotime($post->created_at)) ?>
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
        <?php endforeach; ?>
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        $('.next-post-btn').on('click', function() {
            const $section = $(this).closest('section');
            const $container = $section.find('.post-content-container');
            const $title = $section.find('.post-title');
            const $date = $section.find('.post-date');
            const $readMoreLink = $section.find('.read-more-link');
            
            let postsData = $section.data('posts');

            if (typeof postsData === 'string') {
                try {
                    postsData = JSON.parse(postsData);
                } catch (e) {
                    return;
                }
            }

            const totalPosts = postsData.length;
            if (totalPosts <= 1) return;

            let currentIndex = $section.data('current-index') || 0;
            let nextIndex = (currentIndex + 1) % totalPosts;
            const nextPost = postsData[nextIndex];

            // 1. Start the animation out
            $container.removeClass('animate-in').addClass('animate-out');

            // 2. Wait for the animation out to finish (500ms based on CSS transition)
            setTimeout(() => {
                // 3. Update content
                $title.text(nextPost.title);
                $date.text(nextPost.date);
                $readMoreLink.attr('data-target', `#postModal${nextPost.id}`);
                
                // 4. Update the section's index
                $section.data('current-index', nextIndex);

                // 5. Animate content back in
                $container.removeClass('animate-out').addClass('animate-in');
            }, 300); // 300ms for a snappy transition

        });
    });
</script>
</body>
</html>