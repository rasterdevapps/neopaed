// var player = document.getElementById('player');



//   navigator.mediaDevices.getUserMedia({ audio: true, video: false })
//            .then(handleSuccess);

//             var handleSuccess = function(stream) {
                        
              
//                  const mediaRecorder = new MediaRecorder(stream);
//                  const audioChunks = [];

//                  var recordButton = document.getElementById("start");
//                  var stopButton = document.getElementById("stop");


//                   recordButton.addEventListener("click", start);
//                   stopButton.addEventListener("click", stop);
                          
//                  mediaRecorder.addEventListener("dataavailable", event => {
//                        audioChunks.push(event.data);

//                        console.log(event.data);
//                  });

//                  function start () {
//                     mediaRecorder.start();
//                  }
                     
//                  function stop () {
//                     var audioBlob = new Blob(audioChunks);
//                     var audioUrl = URL.createObjectURL(audioBlob);
//                     console.log(audioUrl);
//                     const audio = new Audio(audioUrl);

//                     mediaRecorder.stop();
//                  }       


              
                        
//           };
 

//  navigator.mediaDevices.getUserMedia({ audio: true })
//   .then(stream => {
//     const mediaRecorder = new MediaRecorder(stream);
//     mediaRecorder.start();

//     const audioChunks = [];
//     mediaRecorder.addEventListener("dataavailable", event => {
//       audioChunks.push(event.data);

//     });

//     mediaRecorder.addEventListener("stop", () => {
//         console.log(audioChunks);
//       const audioBlob = new Blob(audioChunks);
//       const audioUrl = URL.createObjectURL(audioBlob);
//             console.log(audioBlob);

//       const audio = new Audio(audioUrl);
//       console.log(audioUrl);
//       audio.play();
//     });

//     setTimeout(() => {
//       mediaRecorder.stop();
//     }, 3000);
// });

  var audioChunks = [];

  var stream =  navigator.mediaDevices.getUserMedia({ audio: true }).
  then(stream => {

      var mediaRecorder = new MediaRecorder(stream);
      var recordButton = document.getElementById("start");
      var stopButton = document.getElementById("stop");
      
       recordButton.onclick = function() {
          mediaRecorder.start();
          console.log(mediaRecorder.state);
          console.log("recorder started");
          recordButton.style.background = "red";
          recordButton.style.color = "black";
        }

         stopButton.onclick = function() {
          mediaRecorder.stop();
          console.log(mediaRecorder.state);
          console.log("recorder stopped");
          stopButton.style.background = "";
          stopButton.style.color = "";
        }

        mediaRecorder.addEventListener("dataavailable", event => {
          audioChunks.push(event.data);
        });

      mediaRecorder.onstop = function(e) {
        
        var blob = new Blob(chunks, { 'type' : 'audio/ogg; codecs=opus' });
        chunks = [];
        var audioURL = URL.createObjectURL(blob);

        console.log(audioURL);

        console.log("recorder stopped");

     
    }



  });
 

  


//  const recordAudio = () => {
//   return new Promise(resolve => {
//     navigator.mediaDevices.getUserMedia({ audio: true })
//       .then(stream => {

//         var recordButton = document.getElementById("start");
//         var stopButton = document.getElementById("stop");


//         const mediaRecorder = new MediaRecorder(stream);
//         const audioChunks = [];

//         mediaRecorder.addEventListener("dataavailable", event => {
//           audioChunks.push(event.data);
//         });





//         const start = () => {
//           mediaRecorder.start();
//         };

//         const stop = () => {
//           return new Promise(resolve => {
//             mediaRecorder.addEventListener("stop", () => {
//               const audioBlob = new Blob(audioChunks);
//               const audioUrl = URL.createObjectURL(audioBlob);

//               console.log(audioUrl);
//               const audio = new Audio(audioUrl);
//               const play = () => {
//                 audio.play();
//               };

//               resolve({ audioBlob, audioUrl, play });
//             });

//             mediaRecorder.stop();
//           });
//         };

//         resolve({ start, stop });
//       });
//   });
// };

