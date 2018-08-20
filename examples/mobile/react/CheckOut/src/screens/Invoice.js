/**
 * Sample React Native App
 * https://github.com/facebook/react-native
 *
 * @format
 * @flow
 */

import React, {Component} from 'react';
import {Platform,ScrollView, Text,View, StatusBar, ListView} from 'react-native';
import styles from '../style/styles';
import QRCode from 'react-native-qrcode';
import { ViewAttactment } from '../common/index'
const IS_IOS = Platform.OS === 'ios';
type Props = {};
let ds = new ListView.DataSource({rowHasChanged: (r1, r2) => r1 !== r2});
let attachmentList = [];
export default class Invoice extends Component<Props> {
    constructor(props){
        super(props);
        this.state = {
           url: 'https://checkoutapi-dev0.bill24.net/transaction/init',
           data: this.props.navigation.state.params.data,
           imageArrayList: [],
           imageArray: ds.cloneWithRows(attachmentList),
        }
    }

    _renderView(){
        const { data }= this.state;
          return <View style={{flex:1}}>
              <View style={{flex:1}}>
                  <View style={{flex: 1,width:'100%', backgroundColor:'#4FC3F7',justifyContent:'center', alignItem:'center'}}>

                        <Text style={styles.headingTitle}>Invoice</Text>

                        <View style={styles.subTitle}>
                            <Text style={styles.subTextTitle}>Invoice No</Text>
                            <Text style={styles.subTextTitle}>{data.invoice_no}</Text>
                        </View>

                        <View style={styles.subTitle}>
                          <Text style={styles.subTextTitle}>Reference No</Text>
                          <Text style={styles.subTextTitle}>{data.referebce_no}</Text>
                        </View>

                        <View style={styles.subTitle}>
                          <Text style={styles.subTextTitle}>Date </Text>
                          <Text style={styles.subTextTitle}>{data.tran_date}</Text>
                        </View>

                        <View style={styles.subTitle}>
                          <Text style={styles.subTextTitle}>Amount</Text>
                          <Text style={styles.subTextTitle}>{data.amount}</Text>
                        </View>

                        <View style={styles.subTitle}>
                          <Text style={styles.subTextTitle}>Description</Text>
                          <Text style={styles.subTextTitle}>{data.description}</Text>
                        </View>
                        <View style={styles.subTitle}>
                          <Text style={styles.subTextTitle}>Payment Link</Text>
                        </View>
                        <View style={styles.subTitle1}>
                          <QRCode
                           value={data.payment_url}
                           size={100}
                           bgColor='black'
                           fgColor='white'/>
                        </View>
                        <View style={styles.subTitle}>
                          <Text style={styles.subTextTitle}>Payment with agencies:</Text>
                        </View>
                      <View style={styles.subTitle1}>
                        <ViewAttactment
                            dataSource={data.biller_codes}
                            handleOpenImage={()=>{}}
                        />
                      </View>
                  </View>
              </View>
          </View>
    }

    render() {
        console.log("data = ", this.state.data);
    let color = IS_IOS ? "#03A9F4" : "#039BE5";
    return (
        <ScrollView style={styles.container}>
          <StatusBar
             backgroundColor= {color}
             barStyle="light-content"
           />
          {this._renderView()}
        </ScrollView>
    );}
}
