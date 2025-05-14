<x-app-layout>
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-content-wrapper mt-4 radius-20">
                <nav class="navbar navbar-expand bg-light p-0 d-flex justify-content-center">
                    <div class="user-scroll w-auto  overflow-auto text-nowrap">
                        <div class="d-inline-flex m-3">
                            @foreach ($users as $user)
                                <a href="?receiver_id={{ $user->id }}"
                                    class="user-item d-inline-block text-center mx-3 position-relative">
                                    <div class="image-container position-relative"
                                        style="width: 60px; height: 60px; overflow: visible; border-radius: 50%;">
                                        <!-- Notification Badge -->
                                        <img src="{{ getSingleImage($user, 'profile_image')}}"
                                            class="h-100 w-100 object-fit-cover rounded-circle {{($user->id == $receiver->id) ? 'border border-primary' : '' }}"
                                            alt="User" style="object-fit: cover;">
                                        @if (getUnreadMessage($user->id) > 0)
                                            <span
                                                class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-danger">{{ getUnreadMessage($user->id) }}</span>
                                        @endif
                                    </div>
                                    <div class="small mt-1">{{$user->first_name}}</div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </nav>
                <hr>
                <div class="container-fluid vh-100 d-flex flex-column p-0" style="max-height: calc(100vh - 120px);">
                    <!-- Messages container with proper scrolling -->
                    <div id="messages-container" class="flex-grow-1 overflow-auto p-3 d-flex flex-column">
                        <!-- This spacer pushes messages to bottom -->
                        <div class="mt-auto"></div>

                        <!-- Messages content (this will scroll) -->
                        <div id="messages">
                            @foreach($messages as $message)
                                @if($message->sender_id == auth()->id())
                                    <div class="d-flex mb-3 justify-content-end">
                                        <div class="text-end">
                                            <div class="bg-primary text-white p-3 rounded">
                                                <strong>You:</strong> {{ $message->content }}
                                            </div>
                                            <small class="text-muted">{{ $message->created_at->format('h:i A') }}</small>
                                        </div>
                                        <img src="{{ getSingleImage($message->sender, 'profile_image') }}"
                                            class="rounded-circle ms-2" style="width: 60px; height: 60px;" alt="You">
                                    </div>
                                @else
                                    <div class="d-flex mb-3">
                                        <img src="{{ getSingleImage($message->receiver, 'profile_image') }}"
                                            class="rounded-circle me-2" style="width: 60px; height: 60px;" alt="User">
                                        <div>
                                            <div class="bg-light p-3 rounded">
                                                <strong>{{ $message->sender->first_name }}:</strong> {{ $message->content }}
                                            </div>
                                            <small class="text-muted">{{ $message->created_at->format('h:i A') }}</small>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="p-3 theme-border">
                    <form id="message-form" method="POST" action="{{route('messagesSend')}}">
                        @csrf
                        <input type="text" class="form-control" hidden value="{{ optional($receiver)->id }}" name="id">
                        <div class="input-group">
                            <input type="text" id="message-input" name="content" class="form-control"
                                placeholder="Type your message..." required>
                            <button class="btn btn-primary" type="submit">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const messageForm = document.getElementById('message-form');
                const messageInput = document.getElementById('message-input');
                const messagesContainer = document.getElementById('messages-container');
                const messagesDiv = document.getElementById('messages');

                // Handle form submission with AJAX
                messageForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    formData.append('wantsJson', true);

                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Append new message to the UI
                                const newMessage = `
                                                <div class="d-flex mb-3 justify-content-end">
                                                    <div class="text-end">
                                                        <div class="bg-primary text-white p-3 rounded">
                                                            <strong>You:</strong> ${data.message.content}
                                                        </div>
                                                        <small class="text-muted">Just now</small>
                                                    </div>
                                                    <img src="https://placehold.co/40x40" class="rounded-circle ms-2" alt="You">
                                                </div>
                                            `;

                                messagesDiv.insertAdjacentHTML('beforeend', newMessage);
                                messageInput.value = '';

                                // Scroll to bottom
                                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });

                messagesContainer.scrollTop = messagesContainer.scrollHeight;

                setInterval(function () {
                    fetch("{{route(userPrefix() . '.messages')}}")
                        .then(response => response.json())
                        .then(data => {
                        });
                }, 5000);
            });
        </script>
    @endpush
</x-app-layout>