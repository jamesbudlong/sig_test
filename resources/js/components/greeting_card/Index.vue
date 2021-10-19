<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Send A Greeting Card</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <label>Change Background Color:</label>
                <select class="btn btn-sm btn-light" v-model="bgColor" @change="changeBGColorOfCanvass()">
                    <option value="white">White</option>
                    <option value="red">Red</option>
                    <option value="blue">Blue</option>
                    <option value="green">Green</option>
                    <option value="pink">Pink</option>
                    <option value="yellow">Yellow</option>
                </select>
                <br/>
                <label>Text Control:</label>
                <button class="btn btn-sm btn-success" @click="addTextbox()">Add Text</button>
                <button class="btn btn-sm btn-danger" @click="deleteTextbox()">Remove Selected Text</button>
                <canvas id="can" width="800" height="400" style="border:3px solid #000000;"></canvas>
                <br/><br/>
                <label>Recipient: </label>
                <select class="btn btn-sm btn-light" v-model="recipient" required>
                    <option v-for="(option, index) in users" :key="index" :value="index">{{option}}</option>
                </select>
                <button class="btn btn-sm btn-primary" @click="sendCard()">Send Card</button>

                <!-- <img id="image" :src="imgSrc" /> -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
    </div>
  </section>
</template>

<script>
import { fabric } from 'fabric';

    export default {
        data () {
            return {
              bgColor: 'white',
              users: {},
              recipient: '',
              imgSrc: '',
              form: new Form({
                  canvas_data : '',
                  recipient: '',
              })
            }
        },
        methods: {
          changeBGColorOfCanvass(){
              let newColor = this.bgColor;
              this.canvas.backgroundColor = newColor;
              this.canvas.renderAll();
          },
          addTextbox(){
            this.canvas.add(new fabric.IText('Type text here', {
                left: 100,
                top: 100
            }));
          },
          deleteTextbox(){
            this.canvas.remove(this.canvas.getActiveObject());
          },
          fetchUsers(){
              axios.get('/api/user/getUserDropdown').then(({ data }) => (this.users = data.data));
          },
          sendCard(){
              this.$Progress.start();

              //Save first the canvas as img
              let dataURL = this.canvas.toDataURL({
                format: 'png',
                quality: 0.8
              });

              this.form.canvas_data = dataURL;
              this.form.recipient = this.recipient;

              //Save data to db
              this.form.post('/api/greeting_card')
              .then((data)=>{
                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                  this.$Progress.finish();
                  this.canvas.clear();
                  this.recipient = '';
                  this.bgColor = 'white';
              })
              .catch(()=>{

                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
                  });
              })

          }
        },
        mounted() {
            // /this.canvas.backgroundColor = "red";
            var canvas = new fabric.Canvas('can', {
                backgroundColor: "white"
            });
            this.canvas = canvas;
            canvas.selection = false; // disable group selection
            canvas.renderAll();
        },
        created() {
            this.$Progress.start();
            this.fetchUsers();
            this.$Progress.finish();
        }
    }
</script>
