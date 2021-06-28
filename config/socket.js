import io from 'socket.io-client';
import {localhost} from './host';
    //Socket
const socket = io('ws://' + localhost + ':3000/');

export {socket};