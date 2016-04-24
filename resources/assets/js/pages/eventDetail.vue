<style></style>
<template>
    <div class="standard stream-container col-sm-8 col-md-7">
        <h1>{{event.name}}</h1>
        <table>
            <tbody>
            <tr>
                <td>Location: </td>
                <td>{{event.location}}</td>
            </tr>
            <tr>
                <td>Start Date: </td>
                <td>{{event.startDataTime}}</td>
            </tr>
            <tr>
                <td>End Date: </td>
                <td>{{event.startDataTime}}</td>
            </tr>
            <tr>
                <td>Description: </td>
                <td>{{event.description}}</td>
            </tr>
            <tr>
                <td>Picture: </td>
                <td>{{event.pic}}</td>
            </tr>
            <tr>
                <td>How many Join: </td>
                <td>{{numberOfParticipants}}</td>
            </tr>
            </tbody>
        </table>
        <button class="btn btn-info">Edit</button>
    </div>
</template>

<script>
    export default{
        route: {
            data: function (transition) {
                var uri = this.getApi('getEvents') + "/" + this.$route.params.eventId,
                        headers = this.setRequestHeaders(),
                        data = null;
                this.$http.get(uri, data, headers).then(function (response) {
                    transition.next({
                        event: response.data.event,
                        numberOfParticipants: response.data.numberOfParticipants
                    })
                }, function (response) {
                    transition.abort('get no data')
                })
            }
        },
        data: function () {
            return {
                event: {},
                numberOfParticipants:0
            }
        }
    }
</script>