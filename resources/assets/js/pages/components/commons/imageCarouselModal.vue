<style></style>
<template>
    <!-- Modal -->
    <div class="modal fade" id="imageCarouselModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <image-carousel
                        :images="images"
                        :active-item-index="activeItemIndex"
                    ></image-carousel>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ImageCarousel from './imageCarousel.vue'
    export default{
        props:{
            images:{
                type:Array,
                required:true
            },
            activeItemIndex:{
                type:Number,
                default:0
            }
        },
        components:{
            ImageCarousel
        }
    }
</script>