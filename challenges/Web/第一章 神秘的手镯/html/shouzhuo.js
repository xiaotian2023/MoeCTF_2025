const CORRECT_PASSWORD = "VkUpRXYLbkpqYZQtZBOpaIRmsCblcVolXCdboFKykeoYXYmUlPvYVHJsrmazlczaEhgawumAGvRVzXJsyeOzTUBZCFQNcEHRtodwVrkvltIBhBMwItNwOdxdoeLOCswoVnoPDtQyEVqtGraZmAZcZVKVcLajaLoeZAZWDQSFaXeOLTljHfbstUNvDoxpJntJpojvDGAgUKoZaZmrfHIlqbfYZFnFNEgWtKsaBAMgcaiFoClqDjLHnCjQctfVATlMSOeblHJKHCPksZPUPlGHKNTKcnVOHwDMhoJdzAWZvxBzHZKQpLnQtadeDGrtGtlUcyjZqfqbeFrJrhUdICidoHQTaUfNjkJITRDHlVexMipLWiKeCVwemxBnxtkekCLposFnZsrJhytpjmsCrCVkQoCZjzRFAzNVTjEdqKfsfwUEhuTjwVyZAwCfohcRnbiNUqyVZfYSlIuBetGQUOGtbPlcJeHKbFjBTOtGLqsIUfCUXLmcwKDWTQROmwxisWxDzmNWgOCAJOwgYOiqVcwmYFcFqTvTdeQgxZVwpoKQHonXlvYPUWSuXeqjWcuzyHVJaGZqnGcHItLkXvlRteaGhtmwzJlQoTGOvNCrVGsnJpwsZHfwaMjdrbovsvjakagfymNJTfuYVHyLHrvjGVFQoQgJmpUsvTISvSTNAwZFRICjqjLAYAuWMESCLRYGleXmgsbmSOkPHKQhqZaoHLZNfPkBMWSVBLCNDMHYhOkDYiLsmdxLKqpXMQunWpKJvPjeNUkIlYkCFMLTJxehkcxWzImkZgkhFSMJvYEwLsGbfkNxOpwajTnrTpUgMvdeypHMhPNLOrLHDocGsofvgmQBeBxhakuoIhqgSmprQpcWRBoFiKHWKMqCnpLrTOgVhfNGQKYRSqaXixUYTKrqubfhuzitHlkYWMuQwMqLXhYbVWXSMUwEtHFVtaJpvCBteAZiJDlnZXSLnlaHmFjOwvUyLHRSkJzvNkXTGzUStkruMuxCycVTeayVYBkgegPemVNTOsemdXTSOBlcPhRBrDxshupHSBVMdfgdmXpNpFDSXRXYzjTDAOTDCPIvtrPvxjuxLHNtQmqZgiavTalaQaCQbSpReyHDcwrPyukGRPkoDEMiMjvSZWtNEVFISiwMoUFsvMoYEAOlrYCJlwtCBdXwbcVtdcnjQDTbSosBHqpQcKWRMhsEtxWfCDWSPoSIlYzvgWicWVsEjYKJQDGmKDXPqEApHVoQwKZLQBdbvFLsIRqATVAbhfxmwItjrWUlahlsdTMdBWUTUxtzNRdCuxairuHpJLzQdFYtnGfvMHNEOIhYpDJYbAPjpYIXbfdaVhZRYhsERcPzXSFRkbNZafmZsJleiLnTxyXjxwhSUmicufTuBeQRzIPSkRTsDufmBsbNlOvnCjWxYBmxSqZKMjhfyFIlJAyWapjMhbkGyoJPasdRDiuMdREUEdWfhbXpCduhcoqSrvJAUWtaluotyJAckibvqfUvCpvZivygCTkjdjWTozEOaVpXctRXgjTOdhQwxVMZxLGvKsxWQPqZUEYgBXEjwBTcTyfRzjnMaJhdhxBwSNdawoKAlxCiPBPuQvcwMhoIaVXExhvHyEJZPVJpXRoTdZIKgnIQsdfQdivGnowtCpTXafWSJTqmhXvYJCBrHPkndgvTUsUozkxOChMjbNDsvaVYPgMpzTRSUxiRjImAQpgrBstkBDfEgZMvuThQPaJoNvKGByJrlAfiRkAOhiViYdPdNkWjMBcUJoIeCPDYTQGqtUiRqRZQPxSUbtBPLOyqGjhVfORbmBdowGLvGaVLgdIZCdymSUKXnCmpjaCujpxRfKSoEzNzjIEyrLNBgOUsHnmRicnaybJPDyEDPLmyrLaxKZKEokoRdNLqiAGYpDXzFjFyXibscfYIzxvhYtcUesazdQhQMqxgaBKCOCQOVcbsDYgjMTnkxzAjNmfaRYxURiLkxwXzMrFBrvmBSvRvRXVoNsDgBdjYBLrZhdZBrEFPHuKIgRSAQAKZwpcflwIMhlSBkzCSRvMIGVyfHGiGXSnkefymDvulXoQvRXsHZHeQAxSHeyqTSfXCtDHTlqHEAUvySNUqbVxKWQGRZUPxSNjsouFBRidZJGVweIlGrmpaoFwJiAVevozIkJvwLOSQuZDRSXewlpniqGLJlQZardiCizCTKbjTEBhNdwUxFZlulBUsaeXuOewgZhwpmkGjEovefuXrUnYGBjXKpogNSeVhflayIVTUFHvnZqoiZokvlgsWrqgASAJrDaligOtSLZgykRheljBMlzhwrOaEmnJMjKpRHngmvHZyhMaVsfDTLDRQYlsHjLsicuduqhLkQLhVLCXkfQEVFWkPhRXagtGQeVgIjyDhpzYjewIEbJbSuFEShFtaQyLowBaeNdUrjwOEMnFpodofAqrbxrmogmDXqZmFqrTonKAWcGDmIXcynGISwXYKMPtyJzBvbyFOJqSVrmSVfTAJCKJZeucHzbgwOiqHYldqWOZoKXCwHomHfXsyOKVyUAWTjVYvzmsIherMOqzUFwfJFWbLTsWCzoEdKLhLconQGcIueFrcDXgQHSYLpDoHmctrFDvxmgeiAxQxDLPeJzOpvxeXDhulfeXqWIqZlGsTyJSpeykBXsNUgtglFaITJDrkUVkXnJXMFhJNQfKxbHnswGmKAMNeUnERwBHBqfTPUYDZUpOlsEcNVJMHJkcJwTuBlDyfQJNfvJtRcitbmToqjGsjnuWokyAfARhAoIrtCvjFeLqueXyCysyPOlJnTlEoDRNWsTZfCvNzcAKfQljTDmZDHpLtfHfNhEDLPmuvXMfqMjNkgehcMcQAMGuMPyrNdreNATYNGluOzCvbPFWGVSCvNfgVyIsRTscTjanlytQKNlitNHfpYHqrgoDwxTlCuMtgkcKWdXCwUXvOhVjgCJtFpstyjmCapnjNaYDUdaqLZiMcuiaiGvNQBNGBlzAcDaODTXoEjmgeSYTvUPzSvrFdpJRsxQBVuLgOSTLwdlTJTrGRApuyBuSOXfiTbxzxLponpdrQYOPazDYHGseOqUnXyOiGktdyENGowuczQsEpWhAoMuOzUrLtlTGAofZEhduAekEUWKgoHXoKjSUhkVrhyrVDOgnRLJNqOJZeXbzhtPrYxpHlNZeQYgwqwqjTahQSXQgMaEOXvjcqPXWdxMfoEFufWUcYUcloRupDIFUEbUFAsWyAzQJXRoFWpymhCxWyDJIjbNbdHNMhjzcVsaZbGJknpskxGmQeJoDyzAhEcIcgcoiQUiWAcnuHRLEiZQrfcBcirlNAYDYAoGWnkJiJHDYexWXgwPsWhwKgitgLQGoUlcKdbesvNyxpAksIMTItnanPOkAMPLXKTaUsHPbzxcOjzkbiBLnRlCMfRXEhlsAdNtYgeKPnKPMqcxOWzuwmwCihIaliGLtHOkHAUalvGPhOhFCGCtSyixHTzYqKCjlXkogovFKLTGsOsGxGLctFoIuDlmwaioIlZscDApwScysQdGrTbtPNVClnOBCdaznmHNcdInDWeREdnbuAxmYiAvtUJeAoNgcZdGNlPfoMLEzJNSaQJWclYEuAUxTNfsRwldaleLfZeQfVqrTYBMGHvoLnITJyhiPeOygEOyFkZQHIEkvJPIKUnuGyCpaCQcWYEgbmyDtecdRuKDOXqpTSdprlpnvPMnWfHpCsPfAnLRTEBlMXstwgaFAvWRJLdlcaGdiMgAMaOLnBdrYkrzeyxcpbARxQpWsyiZihXfoxlMvHjUmZmweftZbiKflHFjGlqShcpCBDbEYkfeqYbKoeChPqOpmgxhqhChbvgQirEsDFYocPZhpOjQVaXJRFTmRecMLsTIrobjFJdUjpAPbhxwSaIZSWsIhzoQwflmkdnTjXdIQdfolwYnVyuVDmvBxkieNazpkhViqwZRSXzVcJYceDWofHsabfEPyTQBSchopOvuAvrkdTYaeAtokuzMkFTRbXglYpXeKFLGzCkDMOrVpLuKHSwZQWrJefwnrEJLtJCecbKaqXTAQsVQiNiylfGCmaupBoUhnACZNzpTXcHbeyNkFylglQKDAdHCqnYgkSnkskedgvfZchcbVoKCdmIefMIaBCpEDCpGjmAbLHswXmfcHAcirzlTJuKGZTwFzwfjLKFbpFdeqRoNyxcuWgLSqHfLQPQtAhQEUNSKxCzWqLQjXhbJPIMJHoUrUBvionLfvfKtXbFSiAXDAySBEYnFhAUQTvLbivEjXrTBpwntpKZsIKhsjoEhshxditgqlyNOuEhALtnHrqwpdRlJFBFMSDvyuMuYHJtqFmVnwKufyfQHWTASJsJMkUfjqZxToXMzyZIECnPYGLIOzGqksnuathJsDKYiUCNQnvXVpQXDsvCtZFoTcfzdMOwmokHTctvjBGQUApvIyMKFiBWqKVZtmYsPvAdZKHCzGkEcrMWtMfNQOycKQBygPLIDginECaxpeRwGXkjeFICWLNHwLTbigxOEDmkmWqgsOfXCEmLtgcutragMLsEuQwtpgRmGdPEqxkGQhBaJmghgJyXIknvpBqcYMJvwniJbcVrmbotKXRUcfDnGIHioDnLjPaNqsOdTKPoYOCegMhJhjSpTXHUJlpBdpBtofQVJkGbscfRsftKuxbLcaoSPCwuZiFCveFjpasztbaSJYfvGjLZCtclBaVdQJpYUENDmOEMGYXBAZilMFatGoxiACKZLjNuCkLXERmGRprLKbCKYOrBxlhcJgNVIUlTmOtdmSmwUnPWfiGAJeFBQEbJhMbjXFXglTsqEoapCiuzGLpHTJmcuDwOrivWmgYdjmOiZEDPLGNQEcRTJLryvTjUKUdcxkXFSexEmcNaOrnQiGnPqjiCIoHzECujOBpSfVbxIFlaOmvSLyGiGByTHMIgvAFTDADBzHvnvtsNeKoxALIloGFOSTCSvATkArNORyVedcUxswLaHQYVnbEKrLvtKPtZmSHbUCkGckRNGYaBxyzQvPLYFIRYcPEYWcGDizAGFxNJrbnOSXsMfyXRHZaMiZwqKDMvFCJZBZGAHmiHtiknUiHusYQCbtWRiXgBUpRACGBNktaPlsKOFKwTvIAWHJhlRbecdTSDAGSMFMPwlZUrIBcXZROuVFGLJMXZBeRwhOVjLoWJxobefMyHauQLmhFrBxBcfmvTNkLYBjkGHMBYDaJlyebDcXJORuXcyestECJnyHlOzuhcWZSvKcgomoshDMfrSCbZTuKCmlNKABVmYZCMdjKetFlnlNgFZRKBdKietorokrDsNFBxvXeivWopsTqupjfOGJAVoNYPeYfLwfigZlvereIgMqxIgaBxEtSygjfmJVwFvXIxLBPtzRvigznXqGWJKJUHPIsFjfAUIGNczvrstCUWOGJYMKNXtxdGTHbEsnfzCSqOZETQEjTeSreyvBauVuftiaisIavbpMTIjaKbIxljhkDLYOCIugidsYZsiePcpfmFaUyZnsPUBOPIQhDYpFJZpuTKIWQPZNUmKlndqBVuXtoqwQgJXloIXMVspiuTnoHDItWPqKFmqAtDiBnJrmuhNCUXzewatDhkbxpsGtWNBourfckjnoJApwkwoUSxRzIfighspFeHlBLedIBaZWhDEnqUIGRqEzbpEHrfDnEzhUlwXVTgMXtMlQFPMOpDRqRupzmaYjuoWXyjQVnTLreHbQRILYwUiExIQHrUBUPcQfuPjshUokoxlrpBNTcFvHAilAIBZbGNpazSaidJiPSVSPGjCVhWmzufKbXUhbXWYDqKUaSVYLkpedhMZrmulwPcNeVhQHgdTGUTvwMJhBqNrzmyGpeFmkNGaKQTbZHxLxCyZfSOiPgWSPsdgOcyEFdNVCzPFmDiFridqiEQecPJYzSEmLSNUWKwVyhLufNKHphtdJszflFIExprqLvTGhZSyInJUkjFOIMPnrBtoIFCkmOXjvWehXypFhXjpgdqnlpNYzVfukekdrvbDgZsdkTNMckhAkzBfjQXPJtJcFrcupAGPORfHaVPhzdeiDZIotAOJECAotzlvUJrwzkrHynVaJpGpXtoQnOJrxaIveOduwSNXcPgSyvBMsGJhQyxHLobOmURZmslOIWzEBxsNGtsIrAFsqgCwdMskLKmSoQAXOfgIZbRHqFJSbzPWyThwxJmdxZwUSWfDmywzBZqdvkGuBfbgheFofywjXUHQwUBaIviHyQrfuBSYdpyfYoEfTEKUQPREDvQMOAHOvSbGIBLOAfNEXCPgcpuksWgAexTJYgYqHcNVoIcGIsnzCxwvlwRCBfzBmGQzGfMOBlwUxjzruNMHySbnFiXzPVfgYemuRoHZXdZboTdTfVBXpZkiTgjGwurPsvWXMUTbJcYigvpbVbDIRTNsRmHlBYxQKfVcsPoEUpGUVZcHubnACQxaXbnkUDLoYgMDrucPBPBvHLpuqaruHcdcLQKLSAjeZahgeDMZHieHWrhaZntqWgZnFxHsmVxCvWRShFWcvWKYUaoyckPyRxMrDqSopcijkfXoRXizoxWsIZsMWFzLrjZLfJQVIavyJVOekwnpvkFcRLiCfRvrHDRhmxgkgnRoXkSdkuxYedxyaFIHROvgjkSWfiBYGvBZJYncHXjglPagdfCOauESDWDjwhcgCpxOSGChGrUKbAgplusexJbjIoJMrYQufwVXtalkjPZEgcyHktwHJwrItzjPRMbJtHxKrgwXywjuziyJQMcdceTDnqETZAcocwZKIwrXDAfZRzFqZhdlpgQmlvwYRGisnvZWAzdjfKnXibHyZEHraVubuwTkHImiNAIzuyaGhcxsAbmblryGdqiZpSLcLNlJpMAjyWxwqvdAjpyLHZOhnDcGxBqdhAGVgXbJEQsrQYebxvHsLfDzqyrMxuzJaSckybUnjQfPvhqtcDkOzrowDytYZpTNPLpjnQyoDQSwJoivLdueqzSCXdISZknDxvfvhiqSRPvMXeOkvLZWVBZAvlHgOjeTpyvPYFIHnlQTUslXeXbmnZepbKTpcUCkOmKvBAevLUPQMDFhwFOXGCQTGdgtIjPgMSqKJChMDYtsQVKDoCMJAiLOxJsvOhGmQFWqPBPRslSEslUjKWKtlSgoPlpsWdmOLqfubpburfwvoZtnRIKjHpZdpszvWpKxZxjTpzcfDWpXWINOkqTCDMKEbLuaFskiGnFXpRtPyEhrosugbvqujFqlXEMGJmUbzctSaZvLdWZuXgNqGqUTJCygzFlKOYQEVMegCJqBGTfkYbNzTaNJNDfwZSwhvxJGwhdNqIlMiJFILIrtutXzwFbjnTVYXHJbASnpcSiXIzxDOSLmrMgliyhcUAMLUAKcLBoTnsjSzOpOwueSIUDKCEwvgapqdQIeabiLplDxUPSvBAyTVedMAqkguPTekzVfnJBQufwxpFnlBEaBKHxLHLNRdzvAIHJKRCTkdMfEgdnYuMACYEuEvCqowvIpEwrWYOgxMTQEoPZloFQsXTiSiTWnPMgMhLnIvTuyhLxpatpuMfNcBpQNQVmNyJPNEnXDneApYrHtBFRZBmnpqZgJTRzAizNAEWFWpIjOIPtDglsjyBmkIqdoXVuJqotRqewnBQyeMtasZUrxOIkSdyAcjceqkCVMKTsUgNkrNMTxkQNYJhoCMFWshwChQcsfYXUbUqwdXcVGmAiSJQkUQipZYzwPkTKgzOQVxFcLZhDtlfcPxvSGeFoqKIWtQURUNBUneVjuaoGFRDKzQIzlrHMQNRclazUwlXzjASEiYGmTjFceKSyDjZlFixYHGjWTxkvUBREphCMVGwjDyOftflcmuJIDkWPlwJwIHyeDgzxmEwPcLOxSvXwocnUzUEkSCnFHNCJqNYzScRHOpQodtzmXRwhokWRZrcUxVCMNXacRTvBSnrNTasHwONlvsqHSouqCitHcQRgalpuZojXqXezGVZRzqdCkVcMBrskCzCmyQvcmLihbchvgLxYwQWkerjOfKzMBvIVEUNcSWUqhjvSNUcgEHiGZRNjwgLtpMZgUlVARTrvLtuiClwKvpCRGjdqFKQHnoxMDZnfVGboQKBQFhDcGTjQsuClyXqAdsOROSUqDKxeqByrXhdQUDFyaKFwGuPoVOzFNVKHKALgOVPMsljRLmzsJqxaIwJuVMLJMjLijaoWdepVPYIBxFOYxHMFBNPsHcKsEOYWvkNJwCQtIXZoJugmCuqosZNPNVWmdwrGCLeKYUWVHPYieTfGmPtXvGcApKRPNaOmfpuZqcgszpfBqkGstwCfltHvyKTlDQJMQnvqdjixlFpdrKoMLeUmRQHZPlSCQZDCYBNPWlzkzxefvkaQRuqBLSWiDyAvMdgPwPlrJWdBJOZGXHIoywQadaCxjBCwoFpKidtahSJxeowkjSPEgkEtVJAIKNCBsCHvmvtaRvOPdCyEyKSNfgfcVNGmcpSxLfdqSuGcBQzWvgqYMjWrSbvUvKHfDWgLpyuLXrbyKHDZwcAxCbLAzvpGpONrHUWeVmrPRJXIvJmcyMOCnGFxlNtHJSqMIxdnbTJTGnhDCVFICjOdAPxIrUTqJqxmWpbuPobKeaIePRVBpuANzdXrAhILFjZjZMABmnHChWEFBcALWKPtIdbkunmvNAkrmqNHrWHNaoCGyfuRIJCMobejSfRjNkODyOiQWUFIGYfdrYMVrgsfpdNWaSJdamNmcndxnsuFYzcqLTrlxHYvGTAsApADbGyRwLbOSQplEiarGwpdeiwXEQrMuJTkonwiFZqHIfPnxcVEujTmcMHmZCBMSXrKBJauyfquDXcSvhjORznwGsWypVmHmaOmqabGVlNPtErZnHBmKdiSLsnGidfcPesFKgmqIlytWeBoIxLGoquRSibxErSWZncAWPkNVsTgOgzeFtyKtxSiHbCtzyDBPwSOIMaIREVKtJnzCudZJEqxryZPmCVWqVDGdJUsBNlOWJWDMtVzpktzsArwrBTWukEUIvPNtwqpmvGTEGcEizJfyTrEPlKILOUYIANYfeoQdyTRhlkYhsWpkJXAJmvSrgBfmXpCGdsBmnzQehjnUOAJeazoJBgdMrgxMRCzFJXRGAUFnZmjArviHaQodOUtoFocTwVCSoIzXHcvNJwMKNGfJiWDxUfkrSodEXklfiXfoQcXfvaoTbKJaoCGIeXHzoIhYCpvyTepfbMVorMbnocjrSquzUweJwZhxQspDKeyoGCTHKninmndBLcsEyCAIsHmdCNltZLcHcQYIMxbUFMFCZOuEMCTRJHBSeRLRNtxjKCleILBWXunOWQbNXaWMbNOudfbnXUdYgblQphQvErcoQJrcauDhBXgzOYgwkPeFnmFjYwiSNyHDIbJHMHoHPiRtqTdQPGKyxUZmhIclnLvBczomExNjOXCxeLENCOtFyRsLFyvadcousnEProThBQaXyHzuWUaezxmRupaIUsxapBoikqzfzyIMciQuYdhdzIlbrnacuwMjOwTvXbrDGYxYxLrGDYfYRhJewJkMPWClByzMXzulxLTqEuvfkQWkzygNlIbEwdQJZnYEJHrPvApDwAyJFvSbLiejkjowgbPKjSZtdxvzkfwtujxIOsfnGBqdoFPzTJpGYNBPxbMRgnfPwEGkVLdviuAVrTJSDkNZychKDOuyGNudbyersbphlEMPTEdzrzcYOZwCeQWjSrYBhcBRPWFwicGrQFvxYbGrqobhQYMOVNvUiMhdyJUsANqbcTOLynRTjSIdiboiYIpymoZsLgDTVLmybzwJrUXEYxohwFNvoRodRFxFwJYoirFcTAsvXcBGewfJDNpThugezRKDYFlBiglNIvLrHQjEMUWNbhnEhDWaBqeBndEYQXGzDxPQtvtNBsWBvCtZvcfmExJoLOIroXpxFgXdjgwxuxoglGUvesbiVRbgoDcQknlpHClKrKaWNHipSysAvsghVuLVJqsFebadFPeUwBvupSDQYMEnLMflWHiYgsJSkwRuBOVnqO";

document.getElementById('unsealButton').addEventListener('click', validatePassword);
document.getElementById('passwordInput').addEventListener('paste', handlePaste);

// 禁止粘贴功能
function handlePaste(e) {
    e.preventDefault();
    showWarning();
}

function showWarning() {
    const warning = document.querySelector('.warning');
    warning.style.display = 'block';
    setTimeout(() => {
        warning.style.display = 'none';
    }, 2000);
}

// 验证密码
function validatePassword() {
    const input = document.getElementById('passwordInput').value;
    const resultDiv = document.getElementById('result');
    
    if (input === CORRECT_PASSWORD) {
        resultDiv.innerHTML = `
            <div class="success">
                <p>🌟 手镯迸发青光，K皇虚影浮现：</p>
                <p>"小辈不错！此物赠你——"</p>
                <div class="flag">{{FLAG}}</div>
                <p>《金曦玄轨感应篇》已注入神识</p>


                <h4>后续：</h4>
                <p>他摒弃一切杂念，将全部心神凝聚在眼前的光幕上。不再试图去记忆那流动的复杂符文，而是尝试去“理解”这光幕是如何构成的。他的目光穿透了那些流动的金光符文，下意识地寻找着光幕的“源头”或“边界”。</p>
                <p>就在他精神高度集中，尝试用“心”而非“眼”去“看”的刹那，异象再生！</p>
                <p>眼前的光幕景象骤然一变！那些华丽的金光、流动的符文如同潮水般褪去，露出了最原始、最本质的形态——一片由无数细密、规整、闪烁着微光的奇异方格组成的“幕布”。而在幕布最上方，一行与之前咒文风格截然不同的、简洁清晰的文字静静悬浮：</p>
                <p>紧接着下方，才是那行复杂无比的“启封咒”，但此刻它不再流动，而是完整地、静态地展示在一个小小的输入框外。输入框内，清晰地标注着【在此输入万言启封咒】。</p>
                <p>HDdss心中豁然开朗：“神念探查可窥天机！原来天机就藏在这表象之下！”这一个简单的输入框，竟然散发着一种直指本源的道韵，仿佛就是解开一切的“钥匙”，“禁止外物品拓映在手镯上，但是没有禁止拓印在光幕上！只需要把万言咒放入这个输入框内，就可以解开了！”</p>
                <p>他毫不犹豫，不再去直接记忆那复杂咒文本身，而是将全部心神凝聚在那一个小输入框上，把万言咒直接拓印了上去。</p>
                <p>启封手镯的瞬间！</p>
                <p>轰！</p>
                <p>手腕上的手镯爆发出璀璨夺目的金光，瞬间将整个小屋照得亮如白昼！一股庞大而温和的暖流顺着他的手臂汹涌而入，瞬间流遍四肢百骸！HDdss感觉自己的身体仿佛被彻底洗涤，耳聪目明，思维前所未有的清晰灵动，甚至连空气中微尘的浮动轨迹都看得清清楚楚！</p>
                <p>金光缓缓收敛，在手镯上方凝聚成一个约莫尺许高的半透明虚影。那是一位身着古朴金纹玄袍的老者，面容矍铄，眼神深邃如浩瀚星河，周身散发着难以言喻的威严与沧桑。他抚须而笑，声音直接在HDdss脑海中响起，洪亮而充满赞许：</p>
                <p>“好！好！好！破妄之眼，直指本源！能在凡俗之躯，无师自通领悟‘窥天之术’，于混沌表象中寻得唯一真解（Flag），此等悟性，万中无一！老夫‘K皇’，今日得遇良才，幸甚至哉！”</p>
                <p>HDdss被这突如其来的景象震撼得说不出话，只能呆呆地看着眼前这位自称K皇的老者虚影。</p>
                <p>K皇虚影笑容和煦：“小家伙，不必惊慌。此镯乃老夫一缕残魂依附之所，尘封万载，今日为你所启，便是你之机缘。方才你所破之‘禁制’，乃是老夫设下的一道小小考验，名为‘表象迷障’。世间万物，神通术法，乃至人心鬼蜮，往往披着华丽外衣。唯有心志坚定，洞察本源（查看源码），方能窥见真实，不被迷惑。此乃修行路上第一课，亦是万法根基！”</p>
                <p>他顿了顿，继续道：“老夫观你根骨清奇，悟性超凡，更难得是心性坚韧，身处逆境而不堕其志。此等璞玉，岂可埋没于凡尘？你既破我禁制，便是有缘。老夫传你《金曦玄轨感应篇》！”</p>
                <p>一点金光从K皇指尖弹出，没入HDdss眉心。霎时间，一篇玄奥晦涩却又仿佛大道至简的功法口诀清晰地烙印在他脑海深处。同时，一股关于天地灵气、周天运转、修行境界的庞大基础知识也涌入他的意识。</p>
                <p>“此篇乃感应、引气、筑基之无上妙法，尤重神魂锤炼与本源感知，正合你之天赋！勤加修习，踏入仙途指日可待。”K皇的声音带着一丝期许，“至于那玄天剑宗…”</p>
                <p>提到这个名字，K皇的语气带上了一丝不易察觉的轻蔑与玩味。</p>
                <p>“此宗在方圆数万里内，倒也算是个一流宗门。其山门位于据此地向西三千里外的‘天剑山脉’。宗门以剑修为主，外门弟子数万，内门弟子数千，核心真传不过百人。宗门等级森严，资源争夺激烈。你那所谓的‘大哥’赵天虎，不过是去做最低等的杂役弟子，终日做些劈柴挑水、清扫山门的粗活，接触不到核心功法，地位比之外门豢养的灵兽也高不了多少。若无机缘或大笔灵石打点，终其一生，恐怕也难入外门。”</p>
                <p>HDdss听得心潮起伏。原来那高高在上的仙门，内部竟是如此！而大哥的前途…竟如此黯淡？一丝复杂的感觉掠过心头，但很快被对广阔天地的向往所取代。</p>
                <p>“K… K皇前辈，”HDdss终于找回了自己的声音，带着无比的恭敬，“多谢前辈传法！晚辈…晚辈想变强！想踏入仙途！请前辈教我！”</p>
                <p>“哈哈哈！”K皇朗声大笑，“好志气！老夫残魂苏醒，亦需一寄身之所静养恢复。你我有缘，老夫便暂时跟着你，指点你修行入门，助你…进入那玄天剑宗！”</p>
                <p>“进入玄天剑宗？”HDdss一愣。</p>
                <p>“不错！”K皇眼中闪过一丝深邃的光芒，“玄天剑宗虽非顶尖，但作为你踏入修仙界的第一块踏板，却也足够。那里有相对稳定的环境、基础的资源、以及…足够多的‘磨刀石’。更重要的是，其宗门深处，或许藏有与老夫残魂恢复相关的线索。跟着你进去，正是一举两得。”</p>
                <p>他看向HDdss，虚影显得更加凝实了些：“如何？可愿与老夫同行？老夫会指引你修行，教你识破世间万般‘禁制’（Security Vulnerabilities），助你在仙途上，走得更远！”</p>
                <p>小屋内的金光已经完全敛入手镯，只剩下K皇那温和而充满力量的虚影，以及HDdss眼中燃烧起的、前所未有的希望之火。家门的冰冷驱逐，此刻仿佛成了命运的转折点。他握紧了带着温润手镯的左腕，对着K皇的虚影，郑重地躬身行礼：</p>
                <p>“晚辈HDdss，愿随前辈修行！请前辈…多多指教！”</p>
                <p>窗外，夜色依然深沉，但HDdss的心中，已然亮起了一道通往浩瀚仙途的金曦之光。第一步，便是修炼《金曦玄轨感应篇》，然后…玄天剑宗！</p>
                <p>“很好。”K皇满意地点点头，“那便从此刻开始。盘膝坐下，五心朝天，凝神静气，老夫引导你感应这天地间的第一缕‘金曦玄轨’…”</p>
            </div>
        `;
    } else {
        // 显示错误信息
        let errorMsg = '<div class="error">❌ 启封失败！咒文不符天道法则</div>';
        
        // 添加分析提示
        if (input.length === 0) {
            errorMsg += '<p class="hint">提示：下载万言启封咒全文后即可解锁！</p>';
        } else if (input.length < 10000) {
            errorMsg += `<p class="hint">咒文残缺：${input.length}/10000 字符</p>`;
        } else if (input.length > 10000) {
            errorMsg += `<p class="hint">咒文冗长：${input.length}/10000 字符</p>`;
        }
        
        // K皇的嘲讽
        const taunts = [
            "连万言咒都记不住，修什么仙！",
            "凡人的脑子果然不够用",
            "不如回去找你那哥哥哭诉？"
        ];
        const randomTaunt = taunts[Math.floor(Math.random() * taunts.length)];
        
        resultDiv.innerHTML = errorMsg + `<p class="taunt">"${randomTaunt}"</p>`;
    }
}