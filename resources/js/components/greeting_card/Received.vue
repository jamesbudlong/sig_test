<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Received Greeting Cards</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Sender</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr v-for="(received_greeting_card,itemKey) in received_greeting_cards.data" :key="received_greeting_card.id">
                      <td>{{received_greeting_card.id}}</td>
                      <td>{{received_greeting_card.sender[0].name}}</td>
                      <td>
                        <a href="#" @click="viewModal(itemKey)">
                            <i class="fa fa-eye blue"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModal" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">View Greeting Card</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img style="max-width:100%" id="image" :src="imgSrc" />
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>
</template>

<script>
    export default {
        data () {
            return {
              received_greeting_cards : {},
              imgSrc: '',
            }
        },
        methods: {
          loadReceivedGreetingCards(){
            axios.get("/api/greeting_card/receivedGreetingCard").then(({ data }) => (this.received_greeting_cards = data.data));
          },
          viewModal($i){
            console.log(i);
            let img = this.received_greeting_cards.data[i]['canvas_data'];
            $('#viewModal').modal('show');
            this.imgSrc = img;
          },
        },
        mounted() {

        },
        created() {
            this.$Progress.start();
            this.loadReceivedGreetingCards();
            this.$Progress.finish();
        }
    }
</script>
