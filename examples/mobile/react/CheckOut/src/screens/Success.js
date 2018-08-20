/**
 * Sample React Native App
 * https://github.com/facebook/react-native
 *
 * @format
 * @flow
 */

import React, {Component} from 'react';
import {Platform, Text,View, StatusBar} from 'react-native';
import styles from '../style/styles'
const IS_IOS = Platform.OS === 'ios';
type Props = {};

export default class Success extends Component<Props> {
    constructor(props){
        super(props);
        this.state = {
           url: 'https://checkoutapi-dev0.bill24.net/transaction/init',
           data: this.props.navigation.state.params.data,
        }
    }

    _renderView(){
        const { data }= this.state;
          return <View style={{flex:1}}>
              <View style={{flex:1}}>
                  <View style={{flex: 1,width:'100%', backgroundColor:'#4FC3F7',justifyContent:'center', alignItem:'center'}}>

                        <Text style={styles.headingTitle}>Success</Text>

                        <View style={styles.subTitle}>
                            <Text style={styles.subTextTitle}>Bank reference</Text>
                            <Text style={styles.subTextTitle}>{data.bank_reference_no}</Text>
                        </View>

                        <View style={styles.subTitle}>
                          <Text style={styles.subTextTitle}>Fee amount</Text>
                          <Text style={styles.subTextTitle}>{data.fee_amount}</Text>
                        </View>

                        <View style={styles.subTitle}>
                          <Text style={styles.subTextTitle}>Reference </Text>
                          <Text style={styles.subTextTitle}>{data.reference_id}</Text>
                        </View>

                        <View style={styles.subTitle}>
                          <Text style={styles.subTextTitle}>Total amount</Text>
                          <Text style={styles.subTextTitle}>{data.total_amount}</Text>
                        </View>

                        <View style={styles.subTitle}>
                          <Text style={styles.subTextTitle}>Date</Text>
                          <Text style={styles.subTextTitle}>{data.tran_date}</Text>
                        </View>
                  </View>
              </View>
          </View>
    }

    render() {
    let color = IS_IOS ? "#03A9F4" : "#039BE5";
    return (
        <View style={styles.container}>
          <StatusBar
             backgroundColor= {color}
             barStyle="light-content"
           />
          {this._renderView()}
        </View>
    );}
}
