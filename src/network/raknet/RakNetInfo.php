<?php

/**
 *
 *  ____            _        _   __  __ _                  __  __ ____  
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \ 
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/ 
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_| 
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 * 
 *
*/

class RakNetInfo{
	const STRUCTURE = 5;
	const MAGIC = "\x00\xff\xff\x00\xfe\xfe\xfe\xfe\xfd\xfd\xfd\xfd\x12\x34\x56\x78";
	const UNCONNECTED_PING = 0x01;
	const UNCONNECTED_PING_OPEN_CONNECTIONS = 0x02;

	const OPEN_CONNECTION_REQUEST_1 = 0x05;
	const OPEN_CONNECTION_REPLY_1 = 0x06;
	const OPEN_CONNECTION_REQUEST_2 = 0x07;
	const OPEN_CONNECTION_REPLY_2 = 0x08;

	const INCOMPATIBLE_PROTOCOL_VERSION = 0x1a; //CHECK THIS

	const UNCONNECTED_PONG = 0x1c;
	const ADVERTISE_SYSTEM = 0x1d;

	const DATA_PACKET_0 = 0x80;
	const DATA_PACKET_1 = 0x81;
	const DATA_PACKET_2 = 0x82;
	const DATA_PACKET_3 = 0x83;
	const DATA_PACKET_4 = 0x84;
	const DATA_PACKET_5 = 0x85;
	const DATA_PACKET_6 = 0x86;
	const DATA_PACKET_7 = 0x87;
	const DATA_PACKET_8 = 0x88;
	const DATA_PACKET_9 = 0x89;
	const DATA_PACKET_A = 0x8a;
	const DATA_PACKET_B = 0x8b;
	const DATA_PACKET_C = 0x8c;
	const DATA_PACKET_D = 0x8d;
	const DATA_PACKET_E = 0x8e;
	const DATA_PACKET_F = 0x8f;

	const NACK = 0xa0;
	const ACK = 0xc0;

	
	
	public static function isRakNet($pid){
		switch((int) $pid){
			case UNCONNECTED_PING:
			case UNCONNECTED_PING_OPEN_CONNECTIONS:
			case OPEN_CONNECTION_REQUEST_1:
			case OPEN_CONNECTION_REPLY_1:
			case OPEN_CONNECTION_REQUEST_2:
			case OPEN_CONNECTION_REPLY_2:
			case INCOMPATIBLE_PROTOCOL_VERSION:
			case UNCONNECTED_PONG:
			case ADVERTISE_SYSTEM:
			case DATA_PACKET_0:
			case DATA_PACKET_1:
			case DATA_PACKET_2:
			case DATA_PACKET_3:
			case DATA_PACKET_4:
			case DATA_PACKET_5:
			case DATA_PACKET_6:
			case DATA_PACKET_7:
			case DATA_PACKET_8:
			case DATA_PACKET_9:
			case DATA_PACKET_A:
			case DATA_PACKET_B:
			case DATA_PACKET_C:
			case DATA_PACKET_D:
			case DATA_PACKET_E:
			case DATA_PACKET_F:
			case NACK:
			case ACK:
				return true;
			default:
				return false;
		}
	}
}

class Protocol{	
	public static $raknet = array(
		0x01 => array(
			"long", //Ping ID
			"magic",
		),
		0x02 => array(
			"long", //Ping ID
			"magic",
		),

		0x05 => array(
			"magic",
			"byte", //Protocol Version
			"special1", //MTU Size Null Lenght
		),

		0x06 => array(
			"magic",
			"long", //Server GUID
			"byte", //Server Security
			"short", //MTU Size
		),

		0x07 => array(
			"magic",
			"special1", //Security Cookie
			"short", //Server UDP Port
			"short", //MTU Size
			"long", //Client GUID
		),

		0x08 => array(
			"magic",
			"long", //Server GUID
			"short", //Client UDP Port
			"short", //MTU Size
			"byte", //Security
		),

		0x1a => array(
			"byte", //Server Version
			"magic",
			"long", //Server GUID
		),

		0x1c => array(
			"long", //Ping ID
			"long", //Server GUID
			"magic",
			"string", //Data
		),

		0x1d => array(
			"long", //Ping ID
			"long", //Server GUID
			"magic",
			"string", //Data
		),

		0x80 => array(
			"itriad",
			"customData",
		),


		0x81 => array(
			"itriad",
			"customData",
		),

		0x82 => array(
			"itriad",
			"customData",
		),

		0x83 => array(
			"itriad",
			"customData",
		),

		0x84 => array(
			"itriad",
			"customData",
		),

		0x85 => array(
			"itriad",
			"customData",
		),

		0x86 => array(
			"itriad",
			"customData",
		),

		0x87 => array(
			"itriad",
			"customData",
		),

		0x88 => array(
			"itriad",
			"customData",
		),

		0x89 => array(
			"itriad",
			"customData",
		),

		0x8a => array(
			"itriad",
			"customData",
		),

		0x8b => array(
			"itriad",
			"customData",
		),

		0x8c => array(
			"itriad",
			"customData",
		),

		0x8d => array(
			"itriad",
			"customData",
		),

		0x8e => array(
			"itriad",
			"customData",
		),

		0x8f => array(
			"itriad",
			"ubyte",
			"customData",
		),
		
		0x99 => array(
			"byte",
			"special1",
		),

		0xa0 => array(
			"special1",
		),

		0xc0 => array(
			"special1",
		),

	);
	
}