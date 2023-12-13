<style>
    .container {
        /* max-width: 70%; */
        margin: auto;
        overflow-x: hidden;
        overflow-y: hidden;
        padding: 20px;
    }

    /* // small devices  */
    @media (max-width: 576px) {
        .container {
            max-width: 100%;
            margin: auto;
            overflow-x: hidden;
            overflow-y: hidden;
            padding: 20px;
        }
    }
</style>


<div class="container">
    {!! $privacy->description ?? '' !!}
</div>
