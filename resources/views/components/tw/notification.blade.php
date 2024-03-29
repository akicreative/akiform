
<div
    x-data="{
        notifications: [],
        add(e) {
            this.notifications.push({
                id: e.timeStamp,
                type: e.detail.type,
                content: e.detail.content,
            })
        },
        remove(notification) {
            this.notifications = this.notifications.filter(i => i.id !== notification.id)
        },
    }"
    @notifypopup.window="add($event)"
    class="fixed bottom-0 right-0 pr-4 pb-4 max-w-xs w-full flex flex-col space-y-4 sm:justify-start"
    role="status"
    aria-live="polite"
>
    <!-- Notification -->
    <template x-for="notification in notifications" :key="notification.id">
        <div
            x-data="{
                show: false,
                init() {
                    this.$nextTick(() => this.show = true)

                    setTimeout(() => this.transitionOut(), 5000)
                },
                transitionOut() {
                    this.show = false

                    setTimeout(() => this.remove(this.notification), 500)
                },
            }"
            x-show="show"
            x-transition.duration.500ms
            class="relative max-w-sm w-full pl-6 pr-4 py-4 bg-green-100 border border-green-900 rounded-md shadow-lg pointer-events-auto"
        >
            <div class="flex items-start">
                <!-- Icons -->
                <div x-show="notification.type === 'info'" class="flex-shrink-0">
                    <span aria-hidden="true" class="w-6 h-6 inline-flex items-center justify-center text-xl font-bold text-gray-400 border-2 border-gray-400 rounded-full">!</span>
                    <span class="sr-only">Information:</span>
                </div>

                <div x-show="notification.type === 'success'" class="flex-shrink-0">
                    <span aria-hidden="true" class="w-6 h-6 inline-flex items-center justify-center text-lg font-bold text-green-600 border-2 border-green-600 rounded-full">&check;</span>
                    <span class="sr-only">Success:</span>
                </div>

                <div x-show="notification.type === 'error'" class="flex-shrink-0">
                    <span aria-hidden="true" class="w-6 h-6 inline-flex items-center justify-center text-lg font-bold text-red-600 border-2 border-red-600 rounded-full">&times;</span>
                    <span class="sr-only">Error:</span>
                </div>

                <!-- Text -->
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p x-text="notification.content" class="text-sm leading-5 font-bold text-gray-900"></p>
                </div>

                <!-- Remove button -->
                <div class="ml-4 flex-shrink-0 flex">
                    <button @click="transitionOut()" type="button" class="inline-flex text-gray-400">
                        <svg aria-hidden class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close notification</span>
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>

<? /*

<!-- Examples of how to dispatch the `notify` event with variable text and type -->
<form
    x-data="{
        content: 'Something happened!',
        type: 'info',
    }"
    class="max-w-lg"
    x-on:submit.prevent="$dispatch('notifypopup', { content, type })"
>
    <div>
        <label for="message" class="text-sm font-bold">
            Message
        </label>

        <input id="message" x-model="content" type="text" class="mt-1 block w-full border border-black rounded px-3 py-2">
    </div>

    <div class="mt-4">
        <label for="type" class="text-sm font-bold">
            Type
        </label>

        <select id="type" x-model="type" type="text" class="mt-1 block w-full border border-black rounded px-3 py-2">
            <option value="info">Info</option>
            <option value="success">Success</option>
            <option value="error">Error</option>
        </select>
    </div>

    <button class="mt-6 inline-flex border border-black rounded shadow px-4 py-2">
        Dispatch notification
    </button>
</form>

*/ ?>