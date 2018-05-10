<form action="{{route ('statuses.store')}}" method="POST">
    @include('shared._error')
    {{csrf_field ()}}

    <textarea name="content" class="form-control" rows="3" placeholder="聊聊新鲜事儿"></textarea>
    <button type="submit" class="btn btn-primary pull-right">发布</button>
</form>