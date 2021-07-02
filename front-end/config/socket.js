import io from 'socket.io-client';
import {host} from './host';
    //Socket
const socket = io('ws://' + host + ':3000/');

export {socket};