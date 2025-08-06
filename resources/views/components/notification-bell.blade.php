    <div
        x-data="{
            notifications: [],
            unreadCount: 0,
            show: false,
            loading: true,
            fetchNotifications() {
                fetch('{{ route('notifications.fetch') }}')
                    .then(response => response.json())
                    .then(data => {
                        this.notifications = data;
                        this.unreadCount = data.length;
                        this.loading = false;
                    });
            },
            markAsRead(notificationId) {
                fetch('{{ route('notifications.read') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ id: notificationId })
                });
            }
        }"
        x-init="
            fetchNotifications();
            Echo.private('App.Models.User.{{ auth()->id() }}')
                .notification((notification) => {
                    let newNotification = {
                        id: notification.id,
                        data: {
                            message: notification.message,
                            url: notification.url
                        }
                    };
                    this.notifications.unshift(newNotification);
                    this.unreadCount++;
                });
        "
        class="relative"
    >
        <!-- Ikon Lonceng -->
        <button @click="show = !show" class="relative text-gray-500 hover:text-gray-700 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            <span x-show="unreadCount > 0" x-text="unreadCount" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"></span>
        </button>

        <!-- Dropdown Notifikasi -->
        <div
            x-show="show"
            @click.away="show = false"
            class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl overflow-hidden z-20"
            style="display: none;"
        >
            <div class="p-4 font-semibold border-b">Notifikasi</div>
            <div class="divide-y max-h-96 overflow-y-auto">
                <template x-if="loading">
                    <div class="p-4 text-center text-gray-500">Memuat...</div>
                </template>
                <template x-if="!loading && notifications.length === 0">
                    <div class="p-4 text-center text-gray-500">Tidak ada notifikasi baru.</div>
                </template>
                <template x-for="notification in notifications" :key="notification.id">
                    <a :href="notification.data.url" @click="markAsRead(notification.id)" class="block p-4 hover:bg-gray-50">
                        <p class="text-sm text-gray-700" x-text="notification.data.message"></p>
                        <p class="text-xs text-gray-400" x-text="notification.data.ticket_title"></p>
                    </a>
                </template>
            </div>
        </div>
    </div>
    