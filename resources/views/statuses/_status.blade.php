<li id="status-{{ $status->id }}">
  <a href="{{ route('users.show', $user->id )}}">
    <img src="{{ $user->gravatar() }}" alt="{{ $user->name }}" class="gravatar"/>
  </a>
  <!-- 微博动态的发布者 -->
  <span class="user">
    <a href="{{ route('users.show', $user->id )}}">{{ $user->name }}</a>
  </span>
  <!-- 发布日期 -->
  <span class="timestamp">
    {{ $status->created_at->diffForHumans() }}
  </span>
  <!-- 发布内容 -->
  <span class="content">{{ $status->content }}</span>
   @can('destroy', $status)
      <form action="{{ route('statuses.destroy', $status->id) }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <button type="submit" class="btn btn-sm btn-danger status-delete-btn">删除</button>
      </form>
  @endcan
</li>